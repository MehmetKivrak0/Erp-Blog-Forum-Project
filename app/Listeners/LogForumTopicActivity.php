<?php

namespace App\Listeners;

use App\Events\ForumTopicCreated;
use Illuminate\Support\Facades\Log;

class LogForumTopicActivity
{
    /**
     * Handle the event.
     */
    public function handle(ForumTopicCreated $event): void
    {
        Log::info("New forum topic created: {$event->topic->title} (ID: {$event->topic->id}) by User ID: {$event->topic->user_id}");
    }
}
