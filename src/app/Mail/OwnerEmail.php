<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;



class OwnerEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $body;
    public $user_email;
    public $shop_name;

    /**
     * Create a new message instance.
     */
    public function __construct($user_email,$shop_name,$subject,$body)
    {
        $this->user_email = $user_email;
        $this->shop_name = $shop_name;
        $this->subject = $subject;
        $this->body = $body;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(

            from: new Address($this->user_email, $this->shop_name),
            subject:'');

    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            text:'email.owner_email_text',
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
