<?php

namespace App\Http\Controllers;

class DashboardController extends Controller {
    public function welcome() {
        return view("guest.welcome");
    }
    public function register() {
        return view("guest.register");
    }
    public function home() {
        return view("panel.home");
    }
}
