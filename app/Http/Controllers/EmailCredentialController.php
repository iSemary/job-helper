<?php

namespace App\Http\Controllers;

use App\Helpers\MailerConfiguration;
use App\Mail\TestMail;
use App\Models\EmailCredentials;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmailCredentialController extends Controller {
    /**
     * The `edit` function retrieves the email credentials for the authenticated user and passes them to
     * the view for display.
     * 
     * @return View a view called "panel.user.email-credentials" and passing the variable 
     * to the view.
     */
    public function edit(): View {
        $emailCredentials = [];
        $emailCredentials = EmailCredentials::where('user_id', auth()->user()->id)->first();
        return view("panel.user.email-credentials", compact('emailCredentials'));
    }

    /**
     * The function updates the email credentials for a user in the database based on the validated input
     * data.
     * 
     * @param Request request The `` parameter is an instance of the `Illuminate\Http\Request`
     * class. It represents the HTTP request made to the server and contains information such as the
     * request method, headers, and input data.
     * 
     * @return JsonResponse A JSON response with the message "Email credentials updated successfully" is
     * being returned.
     */
    public function update(Request $request): JsonResponse {
        // Validate the input data
        $validatedData = $request->validate([
            'mailer' => 'required|string|max:255',
            'host' => 'required|string|max:255',
            'port' => 'required|string|max:64',
            'username' => 'required|email|max:255',
            'password' => 'required|string|max:255',
            'encryption' => 'required|string|max:64',
            'from_address' => 'required|email|max:255',
            'from_name' => 'required|between:0,55',
        ]);
        // Get the authenticated user's ID
        $userId = auth()->user()->id;
        // Check if the email credentials already exists in the database
        $emailCredentials = EmailCredentials::where('user_id', $userId)->first();
        if (!$emailCredentials) {
            // If it doesn't exist, create a new record
            $emailCredentials = new EmailCredentials();
            $emailCredentials->user_id = $userId;
        }

        // Update the email credentials with the validated data
        $emailCredentials->mailer = $validatedData['mailer'];
        $emailCredentials->host = $validatedData['host'];
        $emailCredentials->port = $validatedData['port'];
        $emailCredentials->username = $validatedData['username'];
        $emailCredentials->password = encrypt($validatedData['password']);
        $emailCredentials->encryption = $validatedData['encryption'];
        $emailCredentials->from_address = $validatedData['from_address'];
        $emailCredentials->from_name = $request['from_name'];

        // Save the email credentials to the database
        $emailCredentials->save();

        // Return a JSON response
        return response()->json(['message' => 'Email credentials updated successfully']);
    }

    /**
     * The function retrieves email credentials for the authenticated user, updates the mailer
     * configuration, sends a test email using a custom mailer, and returns a JSON response indicating
     * the success of the operation.
     * 
     * @return JsonResponse a JsonResponse.
     */
    public function test(): JsonResponse {
        $emailCredentials = EmailCredentials::where('user_id', auth()->user()->id)->first();
        // Check if there's email credentials for this user
        if (!$emailCredentials) {
            return response()->json(['message' => 'Email credentials not exists'], 500);
        }

        MailerConfiguration::update($emailCredentials);

        Mail::mailer('custom')->to($emailCredentials->from_address)->send(new TestMail(''));
        return response()->json(['message' => 'Test mail sent successfully']);
    }
}
