<?php

declare(strict_types=1);

namespace App\Controller\Record;

use App\Controller\ControllerInterface;
use App\Service\Record\RecordService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

/**
 * @Route(path="/record/finish/{id}", methods="POST")
 */
class RecordFinishController implements ControllerInterface
{
    private RecordService $recordService;

    public function __construct(
        RecordService $recordService
    ) {
        $this->recordService = $recordService;
    }

    public function __invoke(string $id): Response
    {
        $this->recordService->finish(Uuid::fromString($id));

        return new JsonResponse();
    }
}
