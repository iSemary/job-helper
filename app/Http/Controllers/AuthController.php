<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller {
    public function submitLogin(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Authentication successful
            return response()->json([
                'message' => "Welcome back, redirecting to home...",
                'route' => route("")
            ], 200);
        } else {
            // Authentication failed
            return response()->json([
                'message' => 'Invalid credentials!'
            ], 400);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route("login");
    }
}
