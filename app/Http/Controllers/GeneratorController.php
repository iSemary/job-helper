<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CoverLetter;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Support\Facades\Storage;

class GeneratorController extends Controller {

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

    public static function generatePDFFile($request) {
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
            // CoverLetter::create([
            //     'user_id' => auth()->user()->id,
            //     'company_id' => $request->company_id ?? null,
            //     'content' => $request->file_content,
            //     'file_name' => $request->file_name,
            //     'file_stored_name' => $uniqueName,
            //     'status' => 0,
            // ]);

            $response['success'] = true;
            $response['file_path'] = asset('storage/' . self::coverLetterPath . $uniqueName);
        } catch (Exception $e) {
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function generateCoverLetter(Request $request) {
        try {
            $message = "OK";
            return response()->json(['message' => 'Cover Letter Generated successfully', 'message' => $message]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to generate cover letter'], 500);
        }
    }

    private function preparePromptMessage($request) {
        
    }
}