<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;


    public $message = ''  ,
           $attachment = ''   ,
           $title = ''  ;

    public function __construct( )
    {
       

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.TestEmail',
        );
    }

    public function attachments(): array
    {
        return   []  ;
    }
}
