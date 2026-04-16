<?php

namespace App\Domains\Auth\UseCases;

use App\Domains\Auth\DTOs\ForgotPasswordDTO;
use App\Domains\Auth\Jobs\SendPasswordResetEmailJob;
use App\Domains\Auth\Repositories\Contracts\PasswordResetServiceInterface;

class ForgotPasswordUseCase
{
    public function __construct() {}

    public function execute(ForgotPasswordDTO $dto)
    {
        return SendPasswordResetEmailJob::dispatch($dto->email->getEmail());
    }
}
