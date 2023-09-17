<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplyEmail extends Mailable {
    use Queueable, SerializesModels;
    public $subject;
    public function __construct() {
        $this->subject = "Subject";
    }

    public function build() {
        return $this
            ->subject($this->subject)
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->view('welcome');
    }
}
