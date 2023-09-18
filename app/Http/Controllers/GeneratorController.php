<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;

class GeneratorController extends Controller {
    public function coverLetter() {
        $userInfo = UserInfo::where('user_id', auth()->user()->id)->first();
        return view("panel.generators.cover-letter", compact("userInfo"));
    }
    public function motivationMessage() {
        return view("panel.generators.motivation-message");
    }
}
