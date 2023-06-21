<?php

declare(strict_types=1);

namespace App\Service\Admin;

use App\Api\Request\Admin\AdminAccessRequest;
use App\Entity\User;
use App\Exception\AdminException;
use App\Repository\UserRepository;
use App\Service\Security\UserStorage;
use Symfony\Component\Uid\Uuid;

class AdminUserService
{
    private UserStorage $userStorage;
    private UserRepository $userRepository;

    public function __construct(
        UserStorage $userStorage,
        UserRepository $userRepository
    ) {
        $this->userStorage = $userStorage;
        $this->userRepository = $userRepository;
    }

    /**
     * @return User[]
     */
    public function getList(): array
    {
        $this->checkAdmin();

        return $this->userRepository->findAll();
    }

    public function changeAccess(Uuid $id, AdminAccessRequest $request): void
    {
        $this->checkAdmin();

        $user = $this->userRepository->find($id->toBinary());
        $user->setActive($request->active);

        $this->userRepository->save($user);
    }

    public function delete(Uuid $id): void
    {
        $this->checkAdmin();

        $user = $this->userRepository->find($id->toBinary());

        $this->userRepository->remove($user);
    }

    private function checkAdmin(): void
    {
        if (!$this->userStorage->getUser()->isAdmin()) {
            throw AdminException::access();
        }
    }
}
