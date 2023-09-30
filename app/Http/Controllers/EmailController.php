<?php

namespace App\Http\Controllers;

use App\Helpers\MailerConfiguration;
use App\Interfaces\CompanyStatusesInterface;
use App\Mail\ApplyMail;
use App\Models\Company;
use App\Models\CoverLetter;
use App\Models\Email;
use App\Models\EmailCredentials;
use App\Models\EmailMessage;
use App\Models\UserInfo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailController extends Controller {
    /**
     * The index function retrieves user information, company data, and email credentials for the
     * authenticated user and passes them to the email index view.
     * 
     * @return View a view called "panel.email.index" and passing three variables to the view: ,
     * , and .
     */
    public function index(): View {
        $userInfo = UserInfo::where('user_id', auth()->user()->id)->first();
        $companies = Company::select('id', 'name')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $emailCredentials = EmailCredentials::where('user_id', auth()->user()->id)->first();
        return view("panel.email.index", compact("userInfo", "emailCredentials", 'companies'));
    }

    /**
     * The function sends an email application with attachments, updates the status of the company and
     * cover letter, and saves the email data in the database.
     * 
     * @param Request request The `` parameter is an instance of the `Illuminate\Http\Request`
     * class. It represents the HTTP request made to the server and contains information such as the
     * request method, headers, and input data.
     * 
     * @return JsonResponse a JsonResponse.
     */
    public function send(Request $request): JsonResponse {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'company_id' => 'required|max:255',
                'cover_letter_id' => 'required|max:255',
                'to_address' => 'required|email|max:255',
                'subject' => 'required|max:255',
                'message' => 'required',
                'attachments.*' => 'nullable|mimes:pdf,doc,docx|max:3048',
            ]);

            /**
             * Prepare and send apply email
             */

            $emailCredentials = EmailCredentials::where('user_id', auth()->user()->id)->first();

            MailerConfiguration::update($emailCredentials);

            $validatedData['resume'] = UserInfo::select('resume', 'resume_file_name')
                ->where("user_id", auth()->user()->id)
                ->first();

            $validatedData['cover_letter'] = CoverLetter::select('original_file_name', 'file_name')
                ->where('id', $validatedData['cover_letter_id'])
                ->where("user_id", auth()->user()->id)
                ->first();


            $mailData = $this->prepareMailData($validatedData);

            Mail::mailer('custom')->to($mailData['to'])->send(new ApplyMail($mailData));

            // Mark the company as sent email
            Company::where("id", $validatedData['company_id'])->update(["status" => CompanyStatusesInterface::SENT_APPLY['id']]);
            // Mark the cover letter as sent
            CoverLetter::where('id', $validatedData['cover_letter_id'])
                ->where("user_id", auth()->user()->id)
                ->update(['status' => 1]);
            // Mark the email message as sent
            if ($request['email_message_id']) {
                EmailMessage::where('id', $request['email_message_id'])
                    ->update(['status' => 1]);
            }
            // Save Email Data
            Email::create([
                'user_id' => auth()->user()->id,
                'company_id' => $request->company_id,
                'email_message_id' => $request->email_message_id,
                'cover_letter_id' => $request->cover_letter_id,
                'message_content' => $request->message,
                'status' => 1,
                'type' => $request->type ?? 1
            ]);
            DB::commit();
            return response()->json(['message' => "Application sent successfully"], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getTrace()], 400);
        }
    }


    /**
     * The function `prepareMailData` prepares the data needed to send an email, including the recipient,
     * subject, body, and attachments.
     * 
     * @param array data An array containing the following keys:
     * 
     * @return array an array called .
     */
    private function prepareMailData(array $data): array {
        $mailData = [];
        $mailData['to'] = $data['to_address'];
        $mailData['subject'] = $data['subject'];
        $mailData['body'] = $data['message'];
        /* 
            Prepare attachments files like resume, cover letter, and uploaded files 
        */
        $attachments = [];
        // Resume attachment
        $attachments['resume']['name'] = $data['resume']['resume_file_name'];
        $attachments['resume']['path'] = 'storage/user/resume/' . basename($data['resume']['resume']);
        $attachments['resume']['mime'] = 'application/' . Str::afterLast($data['resume']['resume'], '.');

        // Cover letter attachment
        $attachments['cover_letter']['name'] = $data['cover_letter']['original_file_name'];
        $attachments['cover_letter']['path'] = 'storage/user/cover-letter/' . $data['cover_letter']['file_name'];
        $attachments['cover_letter']['mime'] = 'application/' . Str::afterLast($data['cover_letter']['file_path'], '.');
        // TODO Add user attachments

        $mailData['user_attachments'] = $attachments;
        return $mailData;
    }
}
