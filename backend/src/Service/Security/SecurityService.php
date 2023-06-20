<?php

declare(strict_types=1);

namespace App\Service\Security;

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
        if ($this->userRepository->exists($request->email)) {
            throw SecurityException::exists($request->email);
        }

        $user = (new User())
            ->setEmail($request->email)
            ->setPassword($this->hashPassword($request->password))
        ;

        $this->userRepository->save($user);

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
