<?php

namespace App\Http\Controllers;

use App\Models\EmailCredentials;
use App\Models\UserInfo;

class EmailController extends Controller {
    public function index() {
        $userInfo = UserInfo::where('user_id', auth()->user()->id)->first();
        $emailCredentials = EmailCredentials::where('user_id', auth()->user()->id)->first();

        return view("panel.email.index", compact("userInfo", "emailCredentials"));
    }

}
