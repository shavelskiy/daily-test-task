<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\User;
use App\Exception\RepositoryException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends BaseRepository<User>
 */
class UserRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByEmail(string $email): ?User
    {
        try {
            return $this->findOneBy(['email' => $email]);
        } catch (RepositoryException $e) {
            return null;
        }
    }
}
