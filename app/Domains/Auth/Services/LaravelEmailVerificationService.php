<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\DTOs\VerifyEmailDTO;
use App\Domains\Auth\Exceptions\InvalidVerificationLinkException;
use App\Domains\Auth\Repositories\Contracts\EmailVerificationServiceInterface;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;
use App\Models\User;

class LaravelEmailVerificationService implements EmailVerificationServiceInterface
{
    public function hasValidSignature(VerifyEmailDTO $dto): bool
    {
        return URL::hasValidSignature($dto->request);
    }

    public function markEmailVerified(VerifyEmailDTO $dto): void
    {
        $user = User::findOrFail($dto->userId);

        if (! hash_equals(
            sha1($user->getEmailForVerification()),
            $dto->hash
        )) {
            throw new InvalidVerificationLinkException('Invalid verification hash.');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user)); // Laravel helper

            $user->status = 'active';
            $user->save();
        }
    }
}
