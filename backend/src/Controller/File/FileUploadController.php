<?php

declare(strict_types=1);

namespace App\Controller\File;

use App\Api\Response\File\FileResponse;
use App\Controller\AbstractController;
use App\Exception\ValidationException;
use App\Service\File\FileService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/file", methods="POST")
 */
class FileUploadController extends AbstractController
{
    private FileService $fileService;

    public function __construct(
        FileService $fileService
    ) {
        $this->fileService = $fileService;
    }

    public function __invoke(Request $request): Response
    {
        $file = $request->files->get('file');

        if (!$file instanceof UploadedFile) {
            throw ValidationException::validate();
        }

        return new JsonResponse(
            new FileResponse($this->fileService->upload($file)),
        );
    }
}
