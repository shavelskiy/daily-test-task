<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class AuthToken
{
    /**
     * @ORM\Id
     *
     * @ORM\Column(type="string", unique=true)
     */
    private string $accessToken;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"remove"})
     *
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private User $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $expiresAt;

    public function __construct(User $user, string $accessToken, DateTimeImmutable $expiresAt)
    {
        $this->user = $user;
        $this->accessToken = $accessToken;
        $this->expiresAt = $expiresAt;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getExpiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }
}
