<?php

namespace App\Mail;

use App\Models\Blog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlogUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $blog;
    public $updatingUser;
    /**
     * Create a new message instance.
     */
    public function __construct(Blog $blog, $updatingUser)
    {
        $this->blog = $blog;
        $this->updatingUser = $updatingUser;
    }

    public function build()
    {
        return $this->subject('Your Blog Post Has Been Updated')
                    ->view('emails.blog-updated')
                    ->with([
                        'blogTitle' => $this->blog->title,
                        'updatingUserName' => $this->blog->updatedBy->name,
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Blog Updated Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // view: 'view.name',
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
