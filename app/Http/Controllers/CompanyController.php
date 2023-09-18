<?php

namespace App\Http\Controllers;

class CompanyController extends Controller {
    public function index() {
        return view("panel.companies.index");
    }
}
