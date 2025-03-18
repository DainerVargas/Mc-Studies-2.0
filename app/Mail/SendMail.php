<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $asunto, $text;

    public function __construct($asunto, $text)
    {
        $this->asunto = $asunto;
        $this->text = $text;
    }

    public function build()
    {
        return $this->subject($this->asunto)->view('emails.send-mail')
        ->with(['text' => $this->text, 'asunto' => $this->asunto]);
    }
 
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->asunto,
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
