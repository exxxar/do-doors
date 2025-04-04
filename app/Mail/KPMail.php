<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $attachments;

    public function __construct($name, array $attachments = [])
    {
        $this->name = $name;
        $this->attachments = $attachments;
    }

    public function build()
    {
        $mail = $this->view('emails.kp')
            ->subject('Коммерческое предложение');

        // Добавляем вложения
        foreach ($this->attachments as $filePath) {
            $mail->attach($filePath);
        }

        return $mail;
    }
}
