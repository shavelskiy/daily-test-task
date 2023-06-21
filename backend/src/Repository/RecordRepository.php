<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Record;
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
}
