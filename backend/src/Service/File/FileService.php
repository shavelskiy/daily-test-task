<?php

declare(strict_types=1);

namespace App\Service\File;

use App\Dto\FileData;
use App\Entity\File;
use App\Exception\FileException;
use App\Repository\FileRepository;
use App\Service\Security\UserStorage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

class FileService
{
    private const VALID_FILE_TYPES = [
        'application/pdf',
        'image/jpg',
        'image/jpeg',
        'application/msword',
    ];

    private FileStorage $fileStorage;
    private FileRepository $fileRepository;
    private UserStorage $userStorage;

    public function __construct(
        FileStorage $fileStorage,
        FileRepository $fileRepository,
        UserStorage $userStorage
    ) {
        $this->fileStorage = $fileStorage;
        $this->fileRepository = $fileRepository;
        $this->userStorage = $userStorage;
    }

    public function upload(UploadedFile $uploadedFile): File
    {
        if (!in_array($uploadedFile->getMimeType(), self::VALID_FILE_TYPES, true)) {
            throw FileException::extension();
        }

        $file = new File($this->userStorage->getUser());
        $file
            ->setName($uploadedFile->getClientOriginalName())
            ->setContentType($uploadedFile->getMimeType() ?? $uploadedFile->getClientOriginalExtension())
        ;

        $this->fileStorage->save($file, $uploadedFile);
        $this->fileRepository->save($file);

        return $file;
    }

    public function download(Uuid $id): FileData
    {
        $file = $this->fileRepository->find($id->toBinary());

        return new FileData(
            $file,
            $this->fileStorage->getFileContent($file),
        );
    }
}
