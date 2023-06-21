<?php

declare(strict_types=1);

namespace App\Controller\File;

use App\Controller\AbstractController;
use App\Service\File\FileService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

/**
 * @Route(path="/file/{id}", methods="GET")
 */
class FileDownloadController extends AbstractController
{
    private FileService $fileService;

    public function __construct(
        FileService $fileService
    ) {
        $this->fileService = $fileService;
    }

    public function __invoke(string $id): Response
    {
        $fileData = $this->fileService->download(Uuid::fromString($id));

        return new Response(
            $fileData->getContent()->getContents(),
            200,
            [
                'Content-Type' => $fileData->getFile()->getContentType(),
                'Content-Disposition' => sprintf('attachment; filename=%s', $fileData->getFile()->getName()),
            ],
        );
    }
}
