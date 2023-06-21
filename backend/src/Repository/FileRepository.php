<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\File;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends BaseRepository<File>
 */
class FileRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $manager)
    {
        parent::__construct($manager, File::class);
    }
}
