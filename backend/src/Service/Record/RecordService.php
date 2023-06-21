<?php

declare(strict_types=1);

namespace App\Service\Record;

use App\Api\Request\Record\RecordRequest;
use App\Entity\Record;
use App\Exception\RecordException;
use App\Repository\RecordRepository;
use App\Service\Security\UserStorage;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

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

    /**
     * @return Record[]
     */
    public function getList(DateTimeImmutable $date): array
    {
        return $this->recordRepository->getList(
            $this->userStorage->getUser(),
            $date,
        );
    }

    public function finish(Uuid $id): void
    {
        $record = $this->getRecord($id);

        $record->setDone(true);
        $this->recordRepository->save($record);
    }

    public function delete(Uuid $id): void
    {
        $record = $this->getRecord($id);

        $this->recordRepository->remove($record);
    }

    private function getRecord(Uuid $id): Record
    {
        $record = $this->recordRepository->find($id);

        if (!$record->getUser()->getId()->compare($id)) {
            throw RecordException::access();
        }

        return $record;
    }
}
