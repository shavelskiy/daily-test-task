<?php

declare(strict_types=1);

namespace App\Service\Record;

use App\Api\Request\Record\RecordRequest;
use App\Entity\Record;
use App\Repository\RecordRepository;
use App\Service\Security\UserStorage;

class RecordService
{
    private RecordRepository $recordRepository;
    private UserStorage $userStorage;

    public function __construct(
        RecordRepository $recordRepository,
        UserStorage $userStorage
    ) {
        $this->recordRepository = $recordRepository;
        $this->userStorage = $userStorage;
    }

    public function create(RecordRequest $request): Record
    {
        $record = new Record(
            $this->userStorage->getUser(),
            $request->date,
        );

        $record->setText($request->text);

        $this->recordRepository->save($record);

        return $record;
    }
}
