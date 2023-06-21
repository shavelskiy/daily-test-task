<?php

declare(strict_types=1);

namespace App\Api\Response\File;

use App\Entity\File;

class FileResponse
{
    public string $id;
    public string $name;
    public string $extension;
    public string $link;

    public function __construct(File $file)
    {
        $this->id = (string)$file->getId();
        $this->name = $file->getName();
        $this->extension = $file->getExtension();
        $this->link = sprintf('/v1/file/%s', (string)$file->getId());
    }
}
