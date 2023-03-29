<?php

namespace App\Trait;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait TimestampableTrait
{
    #[Groups(["data:generic"])]
    #[ORM\Column]
    private ?DateTimeImmutable $createdAt;

    #[Groups(["data:generic"])]
    #[ORM\Column]
    private ?DateTimeImmutable $updatedAt;

    #[ORM\PrePersist]
    public function onPrePersist(): void {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getCreatedAt(): DateTimeImmutable {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}