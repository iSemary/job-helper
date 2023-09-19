<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\EmailCredentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailCredentialController extends Controller {
    public function edit() {
        $emailCredentials = [];
        $emailCredentials = EmailCredentials::where('user_id', auth()->user()->id)->first();
        return view("panel.user.email-credentials", compact('emailCredentials'));
    }


    public function update(Request $request) {
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

    public function test() {
        $emailCredentials = EmailCredentials::where('user_id', auth()->user()->id)->first();
        // Check if there's email credentials for this user
        if (!$emailCredentials) {
            return response()->json(['message' => 'Email credentials not exists'], 500);
        }

        $this->updateMailerConfiguration($emailCredentials);

        Mail::mailer('custom')->to($emailCredentials->from_address)->send(new TestMail(''));
        return response()->json(['message' => 'Test mail sent successfully']);
    }

    public function updateMailerConfiguration($emailCredentials) {
        $mailerConfig = [
            'transport' => $emailCredentials->mailer,
            'host' => $emailCredentials->host,
            'port' => $emailCredentials->port,
            'encryption' => $emailCredentials->encryption,
            'username' => $emailCredentials->username,
            'password' => $emailCredentials->password,
            'timeout' => null,
        ];

        config(['mail.mailers.custom' => $mailerConfig]);
    }
}
