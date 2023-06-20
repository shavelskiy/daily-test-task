<?php

namespace App\Api\Response\Security;

use App\Entity\User;

class UserResponse
{
    public string $id;
    public string $email;
    public bool $admin;

    public function __construct(User $user)
    {
        $this->id = (string)$user->getId();
        $this->email = $user->getEmail();
        $this->admin = $user->isAdmin();
    }
}
