<?php

declare(strict_types=1);

namespace App\Api\Response\Record;

use App\Api\Response\File\FileResponse;
use App\Api\Response\Security\UserResponse;
use App\Entity\Record;

class RecordResponse
{
    public string $id;
    public string $text;
    public UserResponse $user;

    /** @var FileResponse[] */
    public array $files = [];

    public bool $done;
    public string $date;
    public ?string $createdAt;
    public ?string $updatedAt;

    public function __construct(Record $record)
    {
        $this->id = (string)$record->getId();
        $this->text = $record->getText();
        $this->user = new UserResponse($record->getUser());

        foreach ($record->getFiles() as $file) {
            $this->files[] = new FileResponse($file);
        }

        $this->done = $record->isDone();
        $this->date = $record->getDate()->format('c');
        $this->createdAt = $record->getCreatedAt() !== null ? $record->getCreatedAt()->format('c') : null;
        $this->updatedAt = $record->getUpdatedAt() !== null ? $record->getUpdatedAt()->format('c') : null;
    }
}
