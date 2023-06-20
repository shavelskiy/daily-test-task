<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends BaseException
{
    /**
     * @param ?string[] $fields
     */
    public static function apiDocumentation(string $message, ?array $fields = null): self
    {
        if ($fields === null || empty($fields)) {
            return new self($message, 400);
        }

        return new self(sprintf('%s: %s', implode(', ', $fields), $message), 400);
    }

    public static function constraints(ConstraintViolationListInterface $errors): self
    {
        $result = [];

        foreach ($errors as $error) {
            $result[] = (string)$error->getMessage();
        }

        return new self(implode('; ', $result), 401);
    }

    public static function error(string $error): self
    {
        return new self($error, 402);
    }
}
