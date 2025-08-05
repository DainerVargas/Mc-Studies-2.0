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

    public $teacher, $comprobante, $valor, $periodo;

    public function __construct($teacher, $comprobante, $valor, $periodo)
    {
        $this->teacher = $teacher;
        $this->comprobante = $comprobante;
        $this->valor = $valor;
        $this->periodo = $periodo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Comprobante de Pago',
        );
    }

    public function build()
    {
        return $this->subject('Comprobante de Pago')->view('emails.send-mail')
            ->with(
                [
                    'asunto' => $this->teacher,
                    'text' => $this->valor,
                    'periodo' => $this->periodo,
                ]
            );
    }

    /**
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
