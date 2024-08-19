<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendVerifyOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $code;

    /**
     * Create a new message instance.
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Logging hints for debugging purposes
        logger()->info(view()->getFinder()->getHints());

        // Check if the view exists
        if (!view()->exists('emails.verify-email-otp')) {
            logger()->error('View file not found!');
            abort(404, 'View file not found!');
        }
        // Return the markdown view with the OTP code passed to the view
        return $this->markdown('emails.verify-email-otp')
            ->with('code', $this->code);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Verification OTP'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-email-otp'
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
