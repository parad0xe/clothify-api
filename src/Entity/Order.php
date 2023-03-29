<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use App\Trait\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ORM\HasLifecycleCallbacks]
class Order
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'cartOrder', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?ArchiveCart $archiveCart = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column(length: 200)]
    private ?string $reference = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?OrderStatus $orderStatus = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArchiveCart(): ?ArchiveCart
    {
        return $this->archiveCart;
    }

    public function setArchiveCart(ArchiveCart $archiveCart): self
    {
        $this->archiveCart = $archiveCart;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getOrderStatus(): ?OrderStatus
    {
        return $this->orderStatus;
    }

    public function setOrderStatus(?OrderStatus $orderStatus): self
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }
}
