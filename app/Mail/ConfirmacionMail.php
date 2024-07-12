<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmacionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $aprendiz;
    /**
     * Create a new message instance.
     */
    public function __construct($aprendiz)
    {
        $this->aprendiz = $aprendiz;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registro Exitoso, MC Languaje studies',
        );
    }

    public function build()
    {
        
        return $this->subject('Recordatorio de pago')->view('emails.confirmEmail')
            ->with(['aprendiz' => $this->aprendiz]);
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
