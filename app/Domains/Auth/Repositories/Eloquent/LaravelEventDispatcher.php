<?php

namespace App\Domains\Auth\Repositories\Eloquent;

use App\Domains\Auth\Repositories\Contracts\EventDispatcherInterface;

class LaravelEventDispatcher implements EventDispatcherInterface
{
    public function dispatch(object $event): void
    {
        event($event);
    }
}
