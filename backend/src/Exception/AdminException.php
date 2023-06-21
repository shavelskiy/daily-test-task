<?php

declare(strict_types=1);

namespace App\Exception;

class AdminException extends BaseException
{
    public static function access(): self
    {
        return new self('access denied', 600);
    }
}
