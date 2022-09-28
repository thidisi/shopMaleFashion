<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRoleEnum extends Enum
{
    public const STAFF = 1;
    public const MANAGER = 2;
    public const ADMIN = 3;
}
