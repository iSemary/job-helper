<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\EmailCredentials;
use App\Models\UserInfo;
use Illuminate\View\View;
use Illuminate\Http\Request;

class EmailController extends Controller {
    public function index(): View {
        $userInfo = UserInfo::where('user_id', auth()->user()->id)->first();
        $companies = Company::select('id', 'name')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        $emailCredentials = EmailCredentials::where('user_id', auth()->user()->id)->first();
        return view("panel.email.index", compact("userInfo", "emailCredentials", 'companies'));
    }

    public function send(Request $request) {

    }
}
