<?php

declare(strict_types=1);

namespace App\Controller\Record;

use App\Api\Response\Record\RecordResponse;
use App\Controller\ControllerInterface;
use App\Service\Record\RecordService;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/record", methods="GET")
 */
class RecordListController implements ControllerInterface
{
    private RecordService $recordService;

    public function __construct(
        RecordService $recordService
    ) {
        $this->recordService = $recordService;
    }

    public function __invoke(Request $request): Response
    {
        $data = $request->query->get('date');

        $result = [];

        foreach ($this->recordService->getList(new DateTimeImmutable($data !== null ? (string)$data : 'now')) as $record) {
            $result[] = new RecordResponse($record);
        }

        return new JsonResponse($result);
    }
}
