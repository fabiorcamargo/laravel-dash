<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserInvoiceSend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $invoice)
    {
        $this->user = $user;
        $this->invoice = $invoice;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: "Fatura Profissionaliza EAD",
        );
    }

    public function build()
    {
        return $this->markdown('emails.user.invoice-send')
                ->with([
                    'user'=> $this->user,
                    'invoice' => $this->invoice
            ]);
        /*return new Content(
            markdown: 'emails.user.sign',
        );*/
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     *//*
    public function content()
    {
        return $this->markdown('emails.user.sign')
                ->with('user', $this->user);
        /*return new Content(
            markdown: 'emails.user.sign',
        );
    }*/

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
