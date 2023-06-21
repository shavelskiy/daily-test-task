<?php

declare(strict_types=1);

namespace App\Exception;

class RecordException extends BaseException
{
    public static function access(): self
    {
        return new self('you could not edit this record', 400);
    }
}
