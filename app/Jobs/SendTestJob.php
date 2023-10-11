<?php

namespace App\Jobs;

use App\Helpers\MailerConfiguration;
use App\Mail\TestMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTestJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $emailCredentials;
    /**
     * Create a new job instance.
     */
    public function __construct($emailCredentials) {
        $this->emailCredentials = $emailCredentials;
    }

    /**`
     * Execute the job.
     */
    public function handle(): void {
        MailerConfiguration::update($this->emailCredentials);
        Mail::mailer('custom')->to($this->emailCredentials->from_address)->send(new TestMail(''));
    }
}
