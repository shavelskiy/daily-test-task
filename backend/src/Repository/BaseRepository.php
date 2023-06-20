<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\BaseEntity;
use App\Exception\RepositoryException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @template T of object
 *
 * @template-extends ServiceEntityRepository<T>
 */
abstract class BaseRepository extends ServiceEntityRepository
{
    /**
     * @psalm-return T
     *
     * @param mixed      $id
     * @param null|mixed $lockMode
     * @param null|mixed $lockVersion
     */
    public function find($id, $lockMode = null, $lockVersion = null): object
    {
        $result = parent::find($id);

        if ($result === null) {
            throw RepositoryException::notFoundById($this->getEntityNameShort(), (string)$id);
        }

        return $result;
    }

    /**
     * @psalm-return T
     *
     * @psalm-param array<string, mixed> $criteria
     * @psalm-param array<string, string>|null $orderBy
     */
    public function findOneBy(array $criteria, ?array $orderBy = null): object
    {
        $result = parent::findOneBy($criteria, $orderBy);

        if ($result === null) {
            throw RepositoryException::notFound($this->getEntityNameShort(), sprintf('criteria: %s', json_encode($criteria)));
        }

        return $result;
    }

    public function save(BaseEntity $entity): void
    {
        if ($entity->getCreatedAt() === null) {
            $this->_em->persist($entity);
        }

        $this->_em->flush();
    }

    public function remove(BaseEntity $entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    private function getEntityNameShort(): string
    {
        $parts = explode('\\', $this->_entityName);

        return $parts[count($parts) - 1];
    }
}
