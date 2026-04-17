<?php

namespace App\Domains\Organizations\Services;

use App\Domains\Organizations\Repositories\Contracts\OrganizationRepositoryInterface;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationNameVO;
use App\Domains\Organizations\ValueObjects\OrganizationVO\OrganizationSlugVO;
use Illuminate\Support\Str;

class SlugService
{
    public function __construct(
        private OrganizationRepositoryInterface $repository
    ) {}

    public function generateUniqueSlug(OrganizationNameVO $name): OrganizationSlugVO
    {
        $baseSlug = Str::slug($name->value());
        $slug = $baseSlug;
        $counter = 1;

        while ($this->repository->existsBySlug($slug)) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return new OrganizationSlugVO($slug);
    }
}
