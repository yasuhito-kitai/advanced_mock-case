<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class AdminEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $body;
    public $user_email;
    public $user_name;
    /**
     * Create a new message instance.
     */
    public function __construct($user_email, $user_name, $subject, $body)
    {
        $this->user_email = $user_email;
        $this->user_name = $user_name;
        $this->subject = $subject;
        $this->body = $body;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('info@example.com', 'Rese'),
            subject: ''
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            text: 'email.admin_email_text',
            with: [
                'body' => $this->body,
            ]
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
