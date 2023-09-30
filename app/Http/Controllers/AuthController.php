<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {

    /**
     * The function is used for user login authentication in a PHP application, returning a JSON response
     * with a success message and redirect route if authentication is successful, and an error message if
     * authentication fails.
     * 
     * @param Request request The `` parameter is an instance of the `Illuminate\Http\Request`
     * class. It represents the HTTP request made to the server and contains information such as the
     * request method, headers, and input data.
     * 
     * @return JsonResponse The login function returns a JsonResponse. If the authentication is successful,
     * it returns a JSON response with a success message and the route to redirect to. If the
     * authentication fails, it returns a JSON response with an error message.
     */
    public function login(Request $request): JsonResponse {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Authentication successful
            return response()->json([
                'message' => "Welcome back, redirecting to home...",
                'route' => route("panel.home")
            ], 200);
        } else {
            // Authentication failed
            return response()->json([
                'message' => 'Invalid credentials!'
            ], 400);
        }
    }

    /**
     * The function registers a new user by validating the request data, creating a new user record,
     * logging in the user, and returning a JSON response indicating success.
     * 
     * @param Request request The  parameter is an instance of the Request class, which represents
     * an HTTP request made to the server. It contains information about the request, such as the request
     * method, headers, and input data.
     * 
     * @return JsonResponse a JSON response with a message indicating that the user has been registered
     * successfully, and the route to the home page of the panel. The response has a status code of 200.
     */
    public function register(Request $request): JsonResponse {
        $userData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required|max:255',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password']),
        ]);

        // Optionally, you can log in the user after registration
        auth()->login($user);

        // Return a response indicating success
        return response()->json([
            'message' => 'User registered successfully',
            'route' => route("panel.home")
        ], 200);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route("auth.login");
    }
}
