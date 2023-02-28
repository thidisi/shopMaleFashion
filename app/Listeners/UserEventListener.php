<?php

namespace App\Listeners;

use App\Events\User\MailNotiUser;
use App\Notifications\User\VerifyUserMail;

class UserEventListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
    }

    /**
     * Notify User the event
     * @param NotifyUserMail $event
     * @return void
     */
    public function onNotifyUserMail(MailNotiUser $event)
    {
        $user = $event->user;
        $param = $event->param;
        return $user->notify(new VerifyUserMail($param));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen(
            MailNotiUser::class,
            'App\Listeners\UserEventListener@onNotifyUserMail',
        );
    }
}
