<?php

namespace App\Listeners;

use App\Events\Customer\ForgotPassword;
use App\Notifications\Customer\VerifyForgotPasswordMail;

class CustomerEventListener
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
     * Notify Customer the event
     * @param ForgotPassword $event
     * @return void
     */
    public function onNotifyForgotPasswordMail(ForgotPassword $event)
    {
        $customer = $event->customer;
        $param = $event->param;
        return $customer->notify(new VerifyForgotPasswordMail($param));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen(
            ForgotPassword::class,
            'App\Listeners\CustomerEventListener@onNotifyForgotPasswordMail',
        );
    }
}
