<?php

namespace App\Observers;

use App\Models\ForumTopic;

class ForumTopicObserver
{
    /**
     * Handle the ForumTopic "created" event.
     */
    public function created(ForumTopic $forumTopic): void
    {
        \App\Services\AchievementService::checkFirstPost($forumTopic->user);
    }

    /**
     * Handle the ForumTopic "updated" event.
     */
    public function updated(ForumTopic $forumTopic): void
    {
        //
    }

    /**
     * Handle the ForumTopic "deleted" event.
     */
    public function deleted(ForumTopic $forumTopic): void
    {
        //
    }

    /**
     * Handle the ForumTopic "restored" event.
     */
    public function restored(ForumTopic $forumTopic): void
    {
        //
    }

    /**
     * Handle the ForumTopic "force deleted" event.
     */
    public function forceDeleted(ForumTopic $forumTopic): void
    {
        //
    }
}
