<?php

declare(strict_types=1);

namespace App\Exception;

class SecurityException extends BaseException
{
    public static function exists(string $email): self
    {
        return new self(sprintf('user with email %s alreay exists', $email), 200);
    }

    public static function auth(): self
    {
        return new self('invalid creditionals', 201);
    }

    public static function notAuth(): self
    {
        return new self('not auth', 202, 401);
    }
}
