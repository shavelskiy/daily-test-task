<?php

declare(strict_types=1);

namespace App\Exception;

class RepositoryException extends BaseException
{
    public static function notFound(string $entity, string $criteria): self
    {
        return new self(sprintf('entity "%s" not found. criteria: %s', $entity, $criteria), 300);
    }

    public static function access(): self
    {
        return new self('access denied', 301);
    }

    public static function notFullEntity(string $entity, string $field): self
    {
        return new self(sprintf('entity %s not has field: %s', $entity, $field), 302);
    }

    public static function date(string $field): self
    {
        return new self(sprintf('field %s has not valid date', $field), 303);
    }

    public static function notFoundById(string $entity, string $id): self
    {
        return new self(sprintf('%s "%s" не найден', $entity, $id));
    }
}
