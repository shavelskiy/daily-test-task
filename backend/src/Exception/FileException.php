<?php

declare(strict_types=1);

namespace App\Exception;

class FileException extends BaseException
{
    public static function save(string $message): self
    {
        return new self($message, 500);
    }

    public static function download(string $message): self
    {
        return new self($message, 501);
    }

    public static function internal(string $message): self
    {
        return new self($message, 502);
    }

    public static function extension(): self
    {
        return new self('unsupported extension', 503);
    }
}
