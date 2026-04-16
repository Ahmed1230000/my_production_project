<?php

namespace App\Domains\Auth\Listeners;

use App\Domains\Auth\Events\UserRegisteredEvent;
use App\Domains\Auth\Notifications\VerifyEmailNotification;
use App\Models\User;
use Illuminate\Events\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailVerificationListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $afterCommit = true;
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
    public function handleSendEmailVerification(UserRegisteredEvent $event): void
    {
        $userModel = User::findOrFail($event->user->getId());

        $userModel->notify(new VerifyEmailNotification());
    }


    public function subscribe(Dispatcher $events): array
    {
        return
            [
                UserRegisteredEvent::class => 'handleSendEmailVerification',
            ];
    }
}
