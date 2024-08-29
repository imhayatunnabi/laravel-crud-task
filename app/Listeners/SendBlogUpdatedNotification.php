<?php

namespace App\Listeners;

use App\Events\BlogUpdated;
use App\Mail\BlogUpdatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBlogUpdatedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BlogUpdated $event): void
    {
        $blog = $event->blog;
        $updatingUser = $event->updatingUser;

        // Send an email to the user who created the blog post
        Mail::to($blog->creator->email)->send(new BlogUpdatedMail($blog, $updatingUser));
    }
}
