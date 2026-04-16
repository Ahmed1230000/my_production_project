<?php

namespace App\Domains\User\Enums;

enum UserStatusEnum: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DEACTIVATED = 'deactivated';
    case SUSPENDED = 'suspended';
    case DELETED = 'deleted';
}
