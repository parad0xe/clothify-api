<?php

namespace App\Entity;

use App\Repository\ArchiveCartRepository;
use App\Trait\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArchiveCartRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ArchiveCart
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'archiveCarts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'archiveCart', targetEntity: ArchiveCartProduct::class, orphanRemoval: true)]
    private Collection $archiveCartProduct;

    #[ORM\OneToOne(mappedBy: 'archiveCart', cascade: ['persist', 'remove'])]
    private ?Order $cartOrder = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $billingAddress = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $deliveryAddress = null;

    #[ORM\Column]
    private ?int $discountPercentage = null;

    public function __construct()
    {
        $this->archiveCartProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, ArchiveCartProduct>
     */
    public function getArchiveCartProduct(): Collection
    {
        return $this->archiveCartProduct;
    }

    public function addArchiveCartProduct(ArchiveCartProduct $archiveCartProduct): self
    {
        if (!$this->archiveCartProduct->contains($archiveCartProduct)) {
            $this->archiveCartProduct->add($archiveCartProduct);
            $archiveCartProduct->setArchiveCart($this);
        }

        return $this;
    }

    public function removeArchiveCartProduct(ArchiveCartProduct $archiveCartProduct): self
    {
        if ($this->archiveCartProduct->removeElement($archiveCartProduct)) {
            // set the owning side to null (unless already changed)
            if ($archiveCartProduct->getArchiveCart() === $this) {
                $archiveCartProduct->setArchiveCart(null);
            }
        }

        return $this;
    }

    public function getDiscountPercentage(): ?int
    {
        return $this->discountPercentage;
    }

    public function setDiscountPercentage(int $discountPercentage): self
    {
        $this->discountPercentage = $discountPercentage;

        return $this;
    }

    public function getCartOrder(): ?Order
    {
        return $this->cartOrder;
    }

    public function setCartOrder(Order $cartOrder): self
    {
        // set the owning side of the relation if necessary
        if ($cartOrder->getArchiveCart() !== $this) {
            $cartOrder->setArchiveCart($this);
        }

        $this->cartOrder = $cartOrder;

        return $this;
    }

    public function getBillingAddress(): ?Address
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(?Address $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getDeliveryAddress(): ?Address
    {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?Address $deliveryAddress): self
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }
}
