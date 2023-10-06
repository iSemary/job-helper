<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;
use App\Helpers\Uploader;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class UserController extends Controller {
    /**
     * The "edit" function retrieves the user's information from the database and passes it to the view for
     * editing.
     * 
     * @return View a view called "panel.user.info" and passing the variable  to the view.
     */
    public function edit(): View {
        $userInfo = [];
        $userInfo = UserInfo::where('user_id', auth()->user()->id)->first();
        return view("panel.user.info", compact('userInfo'));
    }

    /**
     * The function updates the user information in the database based on the validated input data.
     * 
     * @param Request request The  parameter is an instance of the Request class, which represents
     * an HTTP request. It contains all the data and information about the incoming request, such as the
     * request method, headers, query parameters, form data, and uploaded files. In this code snippet, the
     *  parameter is used to
     * 
     * @return JsonResponse A JSON response with the message "User info updated successfully" is being
     * returned.
     */
    public function update(Request $request): JsonResponse {
        // Validate the input data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'job_title' => 'required|string|max:255',
            'total_experience_years' => 'required|integer|between:0,55',
        ]);
        // Get the authenticated user's ID
        $userId = auth()->user()->id;
        // Check if the user info already exists in the database
        $userInfo = UserInfo::where('user_id', $userId)->first();
        if (!$userInfo) {
            // If it doesn't exist, create a new record
            $userInfo = new UserInfo();
            $userInfo->user_id = $userId;
        }
        // Check if resume is uploaded
        $resume = isset($userInfo->resume) ? basename($userInfo->resume) : null;
        $resumeFileName = $userInfo->resume_file_name;
        if ($request->file('resume')) {
            $resume = Uploader::file($request->file('resume'), $userInfo, 'resume', 'user/resume', false);
            $resumeFileName = $request->file('resume')->getClientOriginalName();
        }
        // Update the user info with the validated data
        $userInfo->first_name = $validatedData['first_name'];
        $userInfo->last_name = $validatedData['last_name'];
        $userInfo->location = $validatedData['location'];
        $userInfo->email = $validatedData['email'];
        $userInfo->phone = $validatedData['phone'];
        $userInfo->job_title = $validatedData['job_title'];
        $userInfo->total_experience_years = $validatedData['total_experience_years'];
        $userInfo->looking_for_relocation = isset($request['looking_for_relocation']) ? 1 : 0;
        $userInfo->resume = $resume;
        $userInfo->resume_file_name = $resumeFileName;
        $userInfo->open_ai_token = encrypt($request->open_ai_token);

        // Save the user info to the database
        $userInfo->save();

        // Return a JSON response
        return response()->json(['message' => 'User info updated successfully', 'status' => 200]);
    }
}
