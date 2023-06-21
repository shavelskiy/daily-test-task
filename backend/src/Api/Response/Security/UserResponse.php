<?php

declare(strict_types=1);

namespace App\Api\Response\Security;

use App\Entity\User;

class UserResponse
{
    public string $id;
    public string $email;
    public bool $admin;
    public bool $active;
    public ?string $createdAt;

    public function __construct(User $user)
    {
        $this->id = (string)$user->getId();
        $this->email = $user->getEmail();
        $this->admin = $user->isAdmin();
        $this->active = $user->isActive();
        $this->createdAt = $user->getCreatedAt() !== null ? $user->getCreatedAt()->format('c') : null;
    }
}
