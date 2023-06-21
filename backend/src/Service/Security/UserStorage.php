<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Entity\AuthToken;
use App\Entity\User;
use App\Exception\SecurityException;

class UserStorage
{
    private ?AuthToken $authToken = null;

    public function setAuthToken(AuthToken $authToken): void
    {
        $this->authToken = $authToken;
    }

    public function getUser(): User
    {
        if ($this->authToken === null) {
            throw SecurityException::notAuth();
        }

        return $this->authToken->getUser();
    }
}
