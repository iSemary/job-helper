<?php

namespace App\Http\Controllers;

use App\Helpers\GPT;
use App\Helpers\PromptFormatter;
use App\Models\Company;
use App\Models\CoverLetter;
use App\Models\EmailMessage;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class GeneratorController extends Controller {
    private $openAiToken;
    const coverLetterPath = "user/cover-letter/";

    public function coverLetter() {
        $userInfo = UserInfo::where('user_id', auth()->user()->id)->first();
        $companies = Company::select('id', 'name')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view("panel.generators.cover-letter", compact("userInfo", 'companies'));
    }
    public function motivationMessage() {
        $userInfo = UserInfo::where('user_id', auth()->user()->id)->first();
        $companies = Company::select('id', 'name')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $type = 1;
        return view("panel.generators.motivation-message", compact("userInfo", 'companies', 'type'));
    }

    public function reminderMessage() {
        $userInfo = UserInfo::where('user_id', auth()->user()->id)->first();
        $companies = Company::select('id', 'name')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $type = 2;
        return view("panel.generators.motivation-message", compact("userInfo", 'companies', 'type'));
    }

    public function company($id) {
        return view("panel.generators.cover-letter", compact("userInfo"));
    }

    public function downloadCoverLetter(Request $request) {
        $pdf = $this->generatePDFFile($request);
        if ($pdf['success']) {
            return response()->json(['message' => 'PDF Generated successfully', 'file_url' => $pdf['file_path']]);
        } else {
            return response()->json(['message' => 'Failed to generate pdf - ' . $pdf['message']], 500);
        }
    }

    public static function generatePDFFile(Request $request) {
        $response = [];
        try {
            $domPDF = new Dompdf();
            // Load HTML content 
            $domPDF->loadHtml($request->file_content);
            $domPDF->setPaper('A4', 'landscape');
            $domPDF->render();

            // Store the pdf file
            $uniqueName = uniqid() . '.pdf';
            $disk = Storage::disk('public');
            $disk->put(self::coverLetterPath . $uniqueName, $domPDF->output());

            // Save the row in database
            if (!$request->download_only) {
                CoverLetter::create([
                    'user_id' => auth()->user()->id,
                    'company_id' => $request->company_id ?? null,
                    'prompt' => $request->prompt,
                    'content' => $request->file_content,
                    'original_file_name' => $request->file_name,
                    'file_name' => $uniqueName,
                    'status' => 0,
                ]);
            }

            $response['success'] = true;
            $response['file_path'] = asset('storage/' . self::coverLetterPath . $uniqueName);
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function generate(Request $request, PromptFormatter $promptFormatter): JsonResponse {
        try {

            $userInfo = UserInfo::where("user_id", auth()->user()->id)->first();
            $company = Company::Auth()->where("id", $request->company_id)->first();
            // Get decrypted open ai token
            $this->openAiToken = $userInfo->open_ai_token;
            // Prepare required data for prompt text
            $data = [];
            $data['job_title'] = $request->job_title;
            $data['job_description'] = $request->job_description;
            $data['company_name'] = $request->company_name;
            $data['user_info'] = $userInfo;
            $data['company'] = $company;
            // Prepare Prompt Text
            $prompt = $promptFormatter->prepare($request->prompt, $data);
            // Send prompt to gpt and get response
            $response = $this->returnGPTResponse($prompt);
            return response()->json(['message' => 'Generated successfully', 'data' => $response]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to generate cover letter', "error" => $e->getMessage()], 500);
        }
    }



    public function saveMessage(Request $request) {
        try {
            EmailMessage::updateOrCreate([
                'company_id' => $request->company_id,
                'type' => $request->type
            ], [
                'prompt' => $request->prompt,
                'content' => $request->content,
            ]);
            return response()->json(['message' => 'Email Message saved successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed on saving email message ' . $e->getMessage()], 500);
        }
    }

    private function returnGPTResponse(string $textPrompt): array {
        $gpt = new GPT($this->openAiToken);
        return $gpt->returnCompletions($textPrompt);
    }
}
