<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class KPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $paths;


    public function __construct($name, $paths)
    {
        $this->name = $name;
        $this->paths = $paths;


    }

    public function attachments(): array
    {
        $tmp = [];

        foreach ($this->paths as $path)
        {
            $tmp[] =   Attachment::fromPath($path);
        }
        return $tmp;
    }

    public function build()
    {
        $mail = $this->view('emails.kp')
            ->subject('Коммерческое предложение');






        return $mail;
    }
}
