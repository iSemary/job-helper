<?php

namespace App\Http\Controllers;

use App\Helpers\GPT;
use App\Models\Company;
use App\Models\CoverLetter;
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
        return view("panel.generators.motivation-message");
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

    public function generateCoverLetter(Request $request): JsonResponse {
        try {
            // Get and decrypt open ai token
            $openAiToken = UserInfo::where("user_id", auth()->user()->id)->first()->open_ai_token;
            $openAiToken = $openAiToken;
            $this->openAiToken = $openAiToken;

            $coverLetterPrompt = $this->preparePromptMessage($request);
            $response = $this->returnGPTResponse($coverLetterPrompt);

            return response()->json(['message' => 'Cover Letter Generated successfully', 'data' => $response]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to generate cover letter', "error" => $e->getMessage()], 500);
        }
    }

    private function preparePromptMessage(Request $request): string {
        return $request->prompt;
    }

    private function returnGPTResponse(string $coverLetterPrompt): array {
        $gpt = new GPT($this->openAiToken);
        return $gpt->returnCompletions($coverLetterPrompt);
    }
}
