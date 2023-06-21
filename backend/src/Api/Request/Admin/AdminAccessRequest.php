<?php

declare(strict_types=1);

namespace App\Api\Request\Admin;

use App\Api\Request\RequestDtoInterface;

class AdminAccessRequest implements RequestDtoInterface
{
    public bool $active = false;
}
