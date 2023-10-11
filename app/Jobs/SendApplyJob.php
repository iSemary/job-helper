<?php

namespace App\Jobs;

use App\Helpers\MailerConfiguration;
use App\Mail\ApplyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendApplyJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $emailCredentials;
    private $mailData;
    /**
     * Create a new job instance.
     */
    public function __construct($emailCredentials, $mailData) {
        $this->emailCredentials = $emailCredentials;
        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        MailerConfiguration::update($this->emailCredentials);
        Mail::mailer('custom')->to($this->mailData['to'])->send(new ApplyMail($this->mailData));
    }
}
