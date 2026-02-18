<?php

namespace App\Mail;

use App\Models\RegisterHours;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registerHour;
    public $metodoPago;

    /**
     * Create a new message instance.
     */
    public function __construct(RegisterHours $registerHour, $metodoPago)
    {
        $this->registerHour = $registerHour;
        $this->metodoPago = $metodoPago;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notificación de Pago de Horas - Mc Studies',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-report',
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
