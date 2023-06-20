<?php

declare(strict_types=1);

namespace App\Api\Response\Security;

use App\Entity\AuthToken;

class AuthTokenResponse
{
    public string $token;
    public int $expiresIn;

    public function __construct(AuthToken $authToken)
    {
        $this->token = $authToken->getAccessToken();
        $this->expiresIn = $authToken->getExpiresAt()->getTimestamp();
    }
}
