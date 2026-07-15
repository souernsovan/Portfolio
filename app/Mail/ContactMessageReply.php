<?php

namespace App\Mail;

use App\Models\ContactMessage;
use App\Models\Profile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ContactMessage $contactMessage,
        public string $replyBody,
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->contactMessage->subject
            ? 'Re: ' . $this->contactMessage->subject
            : 'Re: your message';

        return new Envelope(
            subject: $subject,
            replyTo: [Profile::first()?->email ?? config('mail.from.address')],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-reply',
            with: [
                'profile' => Profile::first(),
            ],
        );
    }
}
