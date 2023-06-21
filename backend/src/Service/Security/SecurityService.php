<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Api\Request\Security\AuthRequest;
use App\Api\Request\Security\RegisterRequest;
use App\Entity\User;
use App\Exception\SecurityException;
use App\Repository\UserRepository;

class SecurityService
{
    private const SALT = 'daily-salt';

    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request): User
    {
        if ($this->userRepository->findByEmail($request->email) !== null) {
            throw SecurityException::exists($request->email);
        }

        $user = (new User())
            ->setEmail($request->email)
            ->setPassword($this->hashPassword($request->password))
        ;

        $this->userRepository->save($user);

        return $user;
    }

    public function auth(AuthRequest $request): User
    {
        if (($user = $this->userRepository->findByEmail($request->email)) === null) {
            throw SecurityException::auth();
        }

        if (!$this->validatePassword($user, $request->password)) {
            throw SecurityException::auth();
        }

        if (!$user->isActive()) {
            throw SecurityException::block();
        }

        return $user;
    }

    private function hashPassword(string $password): string
    {
        return sha1(self::SALT . $password);
    }

    private function validatePassword(User $user, string $password): bool
    {
        return $user->getPassword() === $this->hashPassword($password);
    }
}
