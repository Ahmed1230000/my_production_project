<?php

namespace App\Domains\Auth\Jobs;

use App\Domains\Auth\Repositories\Contracts\PasswordResetServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPasswordResetEmailJob implements ShouldQueue
{
    use Queueable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $email)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(PasswordResetServiceInterface $service): void
    {
        $service->sendResetLinkEmail($this->email);
    }
}
