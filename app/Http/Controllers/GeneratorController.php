<?php

namespace App\Http\Controllers;

class GeneratorController extends Controller {
    public function coverLetter() {
        return view("panel.generators.cover-letter");
    }
    public function motivationMessage() {
        return view("panel.generators.motivation-message");
    }
}
