<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer_name;
    public $shop_name;
    public $reservation_date;
    public $reservation_time;
    public $reservation_number;
    /**
     * Create a new message instance.
     */
    public function __construct($subject,$customer_name, $shop_name, $reservation_date, $reservation_time, $reservation_number)
    {
        $this->subject = '【'.$shop_name .'】ご予約の確認について';
        $this->customer_name = $customer_name;
        $this->shop_name = $shop_name;
        $this->reservation_date = $reservation_date;
        $this->reservation_time = $reservation_time;
        $this->reservation_number = $reservation_number;
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
            text: 'email.remainder_text',
            with: [
                'customer_name' => $this->customer_name,
                'shop_name' => $this->shop_name,
                'reservation_date' => $this->reservation_date,
                'reservation_time' => $this->reservation_time,
                'reservation_number' => $this->reservation_number,
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
