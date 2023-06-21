<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Record;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends BaseRepository<Record>
 */
class RecordRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Record::class);
    }

    /**
     * @return Record[]
     */
    public function getList(User $user, DateTimeImmutable $date): array
    {
        return $this->createQueryBuilder('record')
            ->andWhere('record.user = :user')
            ->andWhere('record.date like :date')
            ->orderBy('record.createdAt')
            ->orderBy('record.done')
            ->setParameters([
                'user' => $user->getId()->toBinary(),
                'date' => sprintf('%s%%', $date->format('Y-m-d')),
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
