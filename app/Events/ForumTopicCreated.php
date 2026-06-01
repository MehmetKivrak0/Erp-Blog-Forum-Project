<?php

namespace App\Events;

use App\Models\ForumTopic;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ForumTopicCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public ForumTopic $topic)
    {
    }
}
