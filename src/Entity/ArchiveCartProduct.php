<?php

namespace App\Entity;

use App\Repository\ArchiveCartProductRepository;
use App\Trait\TimestampableTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArchiveCartProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ArchiveCartProduct
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(length: 150)]
    private ?string $brandName = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $collectionName = null;

    #[ORM\Column(length: 150)]
    private ?string $categoryName = null;

    #[ORM\ManyToOne(inversedBy: 'archiveCartProduct')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ArchiveCart $archiveCart = null;

    #[ORM\Column]
    private ?float $weight = null;

    #[ORM\Column]
    private array $stringifyProductAttributs = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getBrandName(): ?string
    {
        return $this->brandName;
    }

    public function setBrandName(string $brandName): self
    {
        $this->brandName = $brandName;

        return $this;
    }

    public function getCollectionName(): ?string
    {
        return $this->collectionName;
    }

    public function setCollectionName(?string $collectionName): self
    {
        $this->collectionName = $collectionName;

        return $this;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): self
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function getStringifyProductAttributs(): array
    {
        return $this->stringifyProductAttributs;
    }

    public function setStringifyProductAttributs(array $stringifyProductAttributs): self
    {
        $this->stringifyProductAttributs = $stringifyProductAttributs;

        return $this;
    }

    public function getArchiveCart(): ?ArchiveCart
    {
        return $this->archiveCart;
    }

    public function setArchiveCart(?ArchiveCart $archiveCart): self
    {
        $this->archiveCart = $archiveCart;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }
}
