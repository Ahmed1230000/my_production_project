<?php

namespace App\Domains\Auth\Repositories\Contracts;

interface EventDispatcherInterface
{
    public function dispatch(object $event): void;
}
