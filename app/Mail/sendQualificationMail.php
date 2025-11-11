<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class sendQualificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $aprendiz, $qualifications;

    public function __construct($aprendiz, $qualifications)
    {
        $this->aprendiz = $aprendiz;
        $this->qualifications = $qualifications;
    }

    public function build()
    {
        return $this->subject('Resultados')->view('downloadqualifications')
            ->with([
                'aprendiz' => $this->aprendiz,
                'qualifications' => $this->qualifications,
            ]);
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Resultados MC-STUDIES',
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
