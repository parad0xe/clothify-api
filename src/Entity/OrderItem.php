<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:data:generic"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $purchase = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:order-item"])]
    private ?Product $product = null;

    #[ORM\Column]
    #[Groups(["read:order-item"])]
    private ?int $quantity = null;

    #[ORM\Column]
    #[Groups(["read:order-item"])]
    private ?float $totalCost = null;

    #[ORM\ManyToMany(targetEntity: ProductAttribut::class)]
    #[Groups(["read:order-item"])]
    private Collection $productAttributs;

    public function __construct()
    {
        $this->productAttributs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchase(): ?Order
    {
        return $this->purchase;
    }

    public function setPurchase(?Order $purchase): self
    {
        $this->purchase = $purchase;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getTotalCost(): ?float
    {
        return $this->totalCost;
    }

    public function setTotalCost(float $totalCost): self
    {
        $this->totalCost = $totalCost;

        return $this;
    }

    /**
     * @return Collection<int, ProductAttribut>
     */
    public function getProductAttributs(): Collection
    {
        return $this->productAttributs;
    }

    public function addProductAttribut(ProductAttribut $productAttribut): self
    {
        if (!$this->productAttributs->contains($productAttribut)) {
            $this->productAttributs->add($productAttribut);
        }

        return $this;
    }

    public function removeProductAttribut(ProductAttribut $productAttribut): self
    {
        $this->productAttributs->removeElement($productAttribut);

        return $this;
    }
}
