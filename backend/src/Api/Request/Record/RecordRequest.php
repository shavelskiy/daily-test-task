<?php

declare(strict_types=1);

namespace App\Api\Request\Record;

use App\Api\Request\RequestDtoInterface;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class RecordRequest implements RequestDtoInterface
{
    /**
     * @Assert\NotBlank
     */
    public string $text = '';

    /**
     * @Assert\NotBlank
     */
    public DateTimeImmutable $date;

    /**
     * @var string[]
     */
    public array $files = [];

    public function __construct(DateTimeImmutable $date)
    {
        $this->date = $date;
    }
}
