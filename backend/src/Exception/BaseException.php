<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;

abstract class BaseException extends RuntimeException
{
    private int $statusCode;

    public function __construct(string $message, int $code = 0, int $statusCode = 400)
    {
        parent::__construct($message, $code);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
