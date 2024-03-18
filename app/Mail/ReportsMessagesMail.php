<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportsMessagesMail extends Mailable
{
    use Queueable, SerializesModels;
   
    /**
     * Create a new message instance.
     */
    public $message_title =  ''  ,
           $message_content  =  '' ,
           $attachment  =  '' ;
    public function __construct(  $message_title  ,  $message_content , $attachment)
    {
        $this->message_title   = $message_title ;
        $this->message_content = $message_content ;
        $this->attachment     = $attachment ;
    }

    /**
     * Get the message envelope.
     */

 

    public function envelope(): Envelope
    {
        return new Envelope(
            subject:     $this->message_title   ,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ReportsMessagesMail',
        );
    }

 

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // return [] ;
        return  $this->attachment  ?    $this->attachment  : [] ;
    }
}
