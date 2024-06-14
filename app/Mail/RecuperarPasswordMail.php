<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecuperarPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newPassword;

    public $usuario;
    /**
     * Create a new message instance.
     */
    public function __construct($newPassword, $usuario)
    {
        $this->newPassword = $newPassword;

        $this->usuario = $usuario;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contraseña Restablecida, MC-Studies',
        );
    }

    public function build()
    {
        
        return $this->subject('Recordatorio de pago')->view('emails.recuperarPassword')
            ->with([
                'usuario' => $this->usuario,
                'newPassword' => $this->newPassword
            ]);
    }

    /**
     * Get the message content definition.
     */

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
