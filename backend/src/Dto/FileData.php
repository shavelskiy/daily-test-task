<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\File;
use GuzzleHttp\Psr7\Stream;

class FileData
{
    private File $file;
    private Stream $content;

    public function __construct(
        File $file,
        Stream $content
    ) {
        $this->file = $file;
        $this->content = $content;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function getContent(): Stream
    {
        return $this->content;
    }
}
