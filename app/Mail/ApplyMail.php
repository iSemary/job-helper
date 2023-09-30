<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplyMail extends Mailable {
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $userAttachments;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData) {
        $this->subject = $mailData['subject'];
        $this->body = $mailData['body'];
        $this->userAttachments = $mailData['user_attachments'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope {
        return new Envelope(subject: $this->subject,);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content {
        return new Content(view: 'mails.apply', with: [
            'body' => $this->body,
        ],);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array {
        return $this->prepareAttachments();
    }

    private function prepareAttachments(): array {
        $preparedAttachments = [];
        if (isset($this->userAttachments) && is_array($this->userAttachments) && count($this->userAttachments)) {
            foreach ($this->userAttachments as $key => $userAttachment) {
                if (isset($userAttachment['path']) && isset($userAttachment['name']) && isset($userAttachment['mime'])) {
                    $preparedAttachments[] = Attachment::fromPath($userAttachment['path'])
                        ->as($userAttachment['name'])
                        ->withMime($userAttachment['mime']);
                }
            }
        }
        return $preparedAttachments;
    }
}
