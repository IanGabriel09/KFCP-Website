<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment; // Add this to enable attachments

class ApplicationReceivedMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $applicant;
    public $cvWebViewLink;

    /**
     * Create a new message instance.
     */
    public function __construct($applicant, $cvWebViewLink)
    {
        $this->applicant = $applicant;
        $this->cvWebViewLink = $cvWebViewLink;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Update',
            cc: [
                new Address(env('MAIL_CC_RECIPIENT'), env('MAIL_CC_NAME')),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.application_received',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
