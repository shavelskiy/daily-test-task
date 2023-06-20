<?php

declare(strict_types=1);

namespace App\Exception;

class SecurityException extends BaseException
{
    public static function exists(string $email): self
    {
        return new self(sprintf('user with email %s alreay exists', $email), 201);
    }
}
