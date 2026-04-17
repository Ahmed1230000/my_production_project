<?php

namespace App\Domains\Organizations\ValueObjects\OrganizationVO;

use App\Domains\Organizations\Exceptions\OrganizationDomainException;

class OrganizationNameVO
{
    public function __construct(
        private string $name
    ) {
        $value = trim($this->name);
        $value = strtolower($value);
        if (strlen($value) < 3) {
            throw new OrganizationDomainException('Organization name So Short');
        }
        $this->name = $value;
    }

    public function equals(self $other): bool
    {
        return $this->name === $other->name;
    }

    public function value(): string
    {
        return $this->name;
    }
}
