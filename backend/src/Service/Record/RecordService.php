<?php

declare(strict_types=1);

namespace App\Service\Record;

use App\Api\Request\Record\RecordRequest;
use App\Entity\Record;
use App\Exception\RecordException;
use App\Repository\FileRepository;
use App\Repository\RecordRepository;
use App\Service\Security\UserStorage;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class RecordService
{
    private RecordRepository $recordRepository;
    private UserStorage $userStorage;
    private FileRepository $fileRepository;

    public function __construct(
        RecordRepository $recordRepository,
        UserStorage $userStorage,
        FileRepository $fileRepository
    ) {
        $this->recordRepository = $recordRepository;
        $this->userStorage = $userStorage;
        $this->fileRepository = $fileRepository;
    }

    public function create(RecordRequest $request): Record
    {
        $user = $this->userStorage->getUser();

        $record = new Record($user, $request->date);
        $record->setText($request->text);

        foreach ($request->files as $fileId) {
            $file = $this->fileRepository->find($fileId);

            if ((string)$file->getUser()->getId() !== (string)$user->getId()) {
                throw RecordException::access();
            }

            $record->addFile($file);
        }

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

        if ((string)$record->getUser()->getId() !== (string)$this->userStorage->getUser()->getId()) {
            throw RecordException::access();
        }

        return $record;
    }
}
