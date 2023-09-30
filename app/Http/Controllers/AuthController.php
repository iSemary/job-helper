<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function login(Request $request) {
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

    public function register(Request $request) {
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
