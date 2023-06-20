<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AuthToken;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<AuthToken>
 */
class AuthTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthToken::class);
    }

    public function save(AuthToken $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function findByToken(string $token): ?AuthToken
    {
        $result = $this->createQueryBuilder('authToken')
            ->andWhere('authToken.accessToken = :token')
            ->andWhere('authToken.expiresAt > :expiresAt')
            ->setParameters([
                'token' => $token,
                'expiresAt' => new DateTimeImmutable(),
            ])
            ->getQuery()
            ->getResult()
        ;

        return !empty($result) ? current($result) : null;
    }

    public function findActiveToken(User $user): ?AuthToken
    {
        $result = $this->createQueryBuilder('authToken')
            ->andWhere('authToken.user = :user')
            ->andWhere('authToken.expiresAt > :expiresAt')
            ->setParameters([
                'user' => $user->getId()->toBinary(),
                'expiresAt' => new DateTimeImmutable(),
            ])
            ->getQuery()
            ->getResult()
        ;

        return !empty($result) ? current($result) : null;
    }
}
