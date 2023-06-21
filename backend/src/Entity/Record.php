<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @ORM\HasLifecycleCallbacks
 */
class Record extends BaseEntity
{
    /**
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"remove"})
     *
     * @ORM\JoinColumn(onDelete="CASCADE")
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
     * @ORM\ManyToMany(targetEntity=File::class)
     *
     * @var Collection<int, File>
     */
    private Collection $files;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $done = false;

    public function __construct(User $user, DateTimeImmutable $date)
    {
        $this->user = $user;
        $this->date = $date;

        $this->files = new ArrayCollection();
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

    /**
     * @return Collection<int, File>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        $this->files->add($file);
        return $this;
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
