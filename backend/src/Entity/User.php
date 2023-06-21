<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="app_user")
 *
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseEntity
{
    /**
     * @ORM\Column(type="string", unique="true")
     */
    private string $email = '';

    /**
     * @ORM\Column(type="string")
     */
    private string $password = '';

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $admin = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $active = true;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
}
