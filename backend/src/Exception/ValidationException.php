<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends BaseException
{
    public static function constraints(ConstraintViolationListInterface $errors): self
    {
        $result = [];

        foreach ($errors as $error) {
            $result[] = (string)$error->getMessage();
        }

        return new self(implode('; ', $result), 100);
    }

    public static function validate(): self
    {
        return new self('validate exception', 101);
    }
}
