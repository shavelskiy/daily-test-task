<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @ORM\HasLifecycleCallbacks
 */
class File extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private User $user;

    /**
     * @ORM\Column(type="string")
     */
    private string $name = '';

    /**
     * @ORM\Column(type="string")
     */
    private string $contentType = '';

    public function __construct(User $user)
    {
        $this->user = $user;
        parent::__construct();
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function setContentType(string $contentType): self
    {
        $this->contentType = $contentType;
        return $this;
    }

    public function getExtension(): string
    {
        $parts = explode('.', $this->name);
        return $parts[count($parts) - 1];
    }
}
