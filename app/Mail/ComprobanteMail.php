<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComprobanteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $teacher;
    public $comprobante;
    public $valor;

    /**
     * Create a new message instance.
     */
    public function __construct($teacher, $comprobante, $valor)
    {
        $this->teacher = $teacher;
        $this->comprobante = $comprobante;
        $this->valor = $valor;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Comprobante de Pago',
        );
    }
    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->subject('Comprobante de Pago')->view('emails.comprobante')
            ->with([
                'teacher' => $this->teacher,
                'valor' => $this->valor,
                ]
            );
    }

    /*     public function content(): Content
    {
        return new Content(
            view: 'emails.comprobante',
            with: [
                'teacher' => $this->teacher
            ]
        );
    } */
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(public_path('users/' . $this->comprobante))
                ->as(basename($this->comprobante))
                ->withMime('application/pdf'),
        ];
    }
}
