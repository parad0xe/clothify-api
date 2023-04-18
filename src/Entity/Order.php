<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Repository\OrderRepository;
use App\Trait\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Post(
            normalizationContext: [
                'groups' => [
                    'write:order'
                ]
            ]
        )
    ]

)]
class Order
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    #[Groups("write:order")]
    private ?string $reference = null;

    #[ORM\Column]
    #[Groups("write:order")]
    private ?float $totalCost = null;

    #[ORM\Column(length: 100)]
    #[Groups("write:order")]
    private ?string $paymentMethod = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("write:order")]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'purchase', targetEntity: OrderItem::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups("write:order")]
    private Collection $orderItems;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("write:order")]
    private ?Address $shippingAddress = null;

    public function __construct() {
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getReference(): ?string {
        return $this->reference;
    }

    public function setReference(string $reference): self {
        $this->reference = $reference;

        return $this;
    }

    public function getTotalCost(): ?float {
        return $this->totalCost;
    }

    public function setTotalCost(float $totalCost): self {
        $this->totalCost = $totalCost;

        return $this;
    }

    public function getPaymentMethod(): ?string {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): self {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getUser(): ?User {
        return $this->user;
    }

    public function setUser(?User $user): self {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setPurchase($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getPurchase() === $this) {
                $orderItem->setPurchase(null);
            }
        }

        return $this;
    }

    public function getShippingAddress(): ?Address {
        return $this->shippingAddress;
    }

    public function setShippingAddress(Address $shippingAddress): self {
        $this->shippingAddress = $shippingAddress;

        return $this;
    }
}
