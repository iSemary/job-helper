<?php

namespace App\Http\Controllers;

class EmailController extends Controller {
    public function index() {
        return view("panel.email.index");
    }

}
