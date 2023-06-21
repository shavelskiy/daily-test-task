<?php

declare(strict_types=1);

namespace App\Controller\Record;

use App\Api\Request\Record\RecordRequest;
use App\Api\Response\Record\RecordResponse;
use App\Controller\AbstractController;
use App\Service\Record\RecordService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/record", methods="POST")
 */
class RecordCreateController extends AbstractController
{
    private RecordService $recordService;

    public function __construct(
        RecordService $recordService
    ) {
        $this->recordService = $recordService;
    }

    public function __invoke(RecordRequest $request): Response
    {
        return new JsonResponse(
            new RecordResponse($this->recordService->create($request)),
        );
    }
}
