<?php

namespace App\Http\Controllers;

use App\Helpers\GPT;
use App\Helpers\PromptFormatter;
use App\Models\Company;
use App\Models\CoverLetter;
use App\Models\Email;
use App\Models\EmailMessage;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GeneratorController extends Controller {
    private $openAiToken;
    const coverLetterPath = "user/cover-letter/";
    /**
     * The function retrieves user information and a list of companies associated with the user, and then
     * returns a view with the retrieved data.
     * 
     * @return View a view called "panel.generators.cover-letter" with the variables  and
     *  passed to it.
     */
    public function coverLetter(): View {
        $userInfo = UserInfo::where('user_id', auth()->user()->id)->first();
        $companies = Company::select('id', 'name')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        return view("panel.generators.cover-letter", compact("userInfo", 'companies'));
    }
    /**
     * The function retrieves user information, company data, and a type value to be used in generating a
     * motivation message view.
     * 
     * @return View a view called "panel.generators.motivation-message" with the variables ,
     * , and .
     */
    public function motivationMessage(): View {
        $userInfo = UserInfo::where('user_id', auth()->user()->id)->first();
        $companies = Company::select('id', 'name')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $type = 1;
        return view("panel.generators.motivation-message", compact("userInfo", 'companies', 'type'));
    }
    /**
     * The function retrieves user information, companies, and a type, and returns a view for generating a
     * reminder message.
     * 
     * @return View a view called "panel.generators.reminder-message" with the variables ,
     * , and .
     */
    public function reminderMessage(): View {
        $userInfo = UserInfo::where('user_id', auth()->user()->id)->first();
        $companies = Company::select('id', 'name')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $type = 2;
        return view("panel.generators.reminder-message", compact("userInfo", 'companies', 'type'));
    }
    /**
     * The function `downloadCoverLetter` generates a PDF file based on the request data and returns a JSON
     * response with the success message and file URL if the PDF is generated successfully, or an error
     * message if it fails.
     * 
     * @param Request request The `` parameter is an instance of the `Request` class, which is used
     * to handle HTTP requests in Laravel. It contains information about the current request, such as the
     * request method, headers, and input data. In this case, it is used to pass any necessary data for
     * generating the
     * 
     * @return JsonResponse a JsonResponse.
     */
    public function downloadCoverLetter(Request $request): JsonResponse {
        $pdf = $this->generatePDFFile($request);
        if ($pdf['success']) {
            return response()->json(['message' => 'PDF Generated successfully', 'file_url' => $pdf['file_path']]);
        } else {
            return response()->json(['message' => 'Failed to generate pdf - ' . $pdf['message']], 500);
        }
    }
    /**
     * The function generates a PDF file from HTML content, stores it on the server, and saves the file
     * details in the database.
     * 
     * @param Request request The `` parameter is an instance of the `Request` class, which is
     * typically used to retrieve data from an HTTP request. It contains information about the request,
     * such as the request method, URL, headers, and any data sent with the request.
     * 
     * @return array an array with two keys: 'success' and 'file_path'. The value of 'success' indicates
     * whether the PDF file generation was successful or not, and the value of 'file_path' is the URL of
     * the generated PDF file.
     */
    public static function generatePDFFile(Request $request): array {
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
    /**
     * The function generates a cover letter based on the user's input and sends it to the GPT model for
     * response.
     * 
     * @param Request request The `` parameter is an instance of the `Illuminate\Http\Request`
     * class. It represents the HTTP request made to the server and contains information such as the
     * request method, headers, and input data.
     * @param PromptFormatter promptFormatter The `` parameter is an instance of the
     * `PromptFormatter` class. It is used to format the prompt text before sending it to the GPT
     * (Generative Pre-trained Transformer) model for generating the response. The `prepare()` method of
     * the `PromptFormatter` class is called to
     * 
     * @return JsonResponse a JsonResponse.
     */
    public function generate(Request $request, PromptFormatter $promptFormatter): JsonResponse {
        try {
            $userInfo = UserInfo::where("user_id", auth()->user()->id)->first();
            // Get decrypted open ai token
            $this->openAiToken = $userInfo->open_ai_token;
            // Prepare required data for prompt text
            $data = [];

            switch ($request->type) {
                case '1': // Motivation Message
                    $company = Company::Auth()->where("id", $request->company_id)->first();
                    $data['job_title'] = $request->job_title;
                    $data['job_description'] = $request->job_description;
                    $data['company_name'] = $request->company_name;
                    $data['user_info'] = $userInfo;
                    $data['company'] = $company;
                    break;
                case '2': // Reminder Message
                    $data['company_name'] = $request->company_name;
                    $data['apply_mail'] = $request->apply_mail;
                    break;
                default:
                    break;
            }
            // Prepare Prompt Text
            $prompt = $promptFormatter->prepare($request->prompt, $data);
            // Send prompt to gpt and get response
            $response = $this->returnGPTResponse($prompt);
            return response()->json(['message' => 'Generated successfully', 'data' => $response, 'prompt' => $prompt]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to generate cover letter', "error" => $e->getMessage()], 500);
        }
    }
    /**
     * The function saves an email message in the database and returns a JSON response indicating the
     * success or failure of the operation.
     * 
     * @param Request request The `` parameter is an instance of the `Illuminate\Http\Request`
     * class. It represents the HTTP request made to the server and contains information such as the
     * request method, headers, and input data.
     * 
     * @return JsonResponse a JsonResponse.
     */
    public function saveMessage(Request $request): JsonResponse {
        try {
            EmailMessage::updateOrCreate([
                'company_id' => $request->company_id,
                'type' => $request->type
            ], [
                'prompt' => $request->prompt,
                'content' => $request->content,
            ]);
            return response()->json(['message' => 'Email Message saved successfully', 'status' => 200]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed on saving email message ' . $e->getMessage()], 500);
        }
    }
    /**
     * The function "returnGPTResponse" takes a text prompt as input and returns an array of completions
     * generated by the GPT model.
     * 
     * @param string textPrompt A string representing the text prompt that will be used as input for the
     * GPT model.
     * 
     * @return array An array is being returned.
     */
    private function returnGPTResponse(string $textPrompt): array {
        $gpt = new GPT($this->openAiToken);
        return $gpt->returnCompletions($textPrompt);
    }
}
