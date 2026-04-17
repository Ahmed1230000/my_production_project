<?php

namespace App\Domains\Organizations\ValueObjects\OrganizationVO;

use App\Domains\Organizations\Exceptions\OrganizationDomainException;

class OrganizationSlugVO
{
    private string $value;

    public function __construct(string $value)
    {
        $value = strtolower(trim($value));

        if (!preg_match('/^[a-z0-9\-]+$/', $value)) {
            throw new OrganizationDomainException("Invalid slug");
        }
        if (strlen($value) < 3) {
            throw new OrganizationDomainException('Slug too short');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
