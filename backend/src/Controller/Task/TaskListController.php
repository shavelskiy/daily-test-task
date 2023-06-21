<?php

declare(strict_types=1);

namespace App\Controller\Task;

use App\Api\Response\Record\RecordResponse;
use App\Controller\ControllerInterface;
use App\Repository\RecordRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/task/record", methods="GET")
 */
class TaskListController implements ControllerInterface
{
    private RecordRepository $recordRepository;

    public function __construct(
        RecordRepository $recordRepository
    ) {
        $this->recordRepository = $recordRepository;
    }

    public function __invoke(): Response
    {
        $result = [];

        foreach ($this->recordRepository->findAll() as $record) {
            $result[] = new RecordResponse($record);
        }

        return new JsonResponse($result);
    }
}
