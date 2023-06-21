<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @ORM\HasLifecycleCallbacks
 */
class Record extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private User $user;

    /**
     * @ORM\Column(type="text")
     */
    private string $text = '';

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $done = false;

    public function __construct(User $user, DateTimeImmutable $date)
    {
        $this->user = $user;
        $this->date = $date;
        parent::__construct();
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function isDone(): bool
    {
        return $this->done;
    }

    public function setDone(bool $done): self
    {
        $this->done = $done;
        return $this;
    }
}
