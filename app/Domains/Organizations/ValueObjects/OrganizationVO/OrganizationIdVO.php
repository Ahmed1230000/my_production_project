<?php

namespace App\Domains\Organizations\ValueObjects\OrganizationVO;

use App\Domains\Organizations\Exceptions\OrganizationDomainException;

class OrganizationIdVO
{
    public function __construct(
        private int $id
    ) {
        if ($this->id <= 0) {
            throw new OrganizationDomainException('Organization ID must be a positive integer.');
        }
    }

    public function equals(self $other): bool
    {
        return $this->id === $other->id;
    }
    public function value(): int
    {
        return $this->id;
    }
}
