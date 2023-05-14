<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Filter\BooleanFilter;
use App\Filter\RangeFilter;
use App\Repository\ProductRepository;
use App\Trait\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            openapiContext: [
                'summary' => "Récupérer un produit à partir de son identifiant"
            ],
            normalizationContext: [
                'openapi_definition_name' => "Detail",
                "groups" => [
                    "read:data:generic",
                    "read:product",
                    "read:product-attribut",
                    "read:product-attribut-category",
                    "read:product-brand",
                    "read:product-category",
                    "read:product-collection",
                    "read:product-rating"
                ]
            ]
        ),
        new GetCollection(
            openapiContext: [
                'summary' => "Récupérer tous les produits (avec pagination)"
            ],
            paginationClientItemsPerPage: false,
            normalizationContext: [
                'openapi_definition_name' => "Collection",
                "groups" => [
                    "read:data:generic",
                    "read:product",
                    "read:product-attribut",
                    "read:product-attribut-category",
                    "read:product-brand",
                    "read:product-category",
                    "read:product-collection",
                    "read:product-rating"
                ]
            ]
        )
    ],
    order: ['price' => 'asc'],
    paginationItemsPerPage: 40
)]
#[ApiFilter(SearchFilter::class, strategy: 'exact', properties: ["name" => "partial", "description" => "partial"])]
#[ApiFilter(RangeFilter::class, properties: ["price", "rating" => "averageRating"])]
#[ApiFilter(BooleanFilter::class, properties: ["new" => "isNew"])]
#[ApiFilter(OrderFilter::class, properties: ['price', 'averageRating'], arguments: ['orderParameterName' => 'order'])]
class Product
{
    use TimestampableTrait;

    #[Groups(["read:data:generic"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["read:product"])]
    #[ORM\Column(length: 150)]
    private ?string $name = null;

    #[Groups(["read:product"])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[Groups(["read:product"])]
    #[ORM\Column]
    private ?float $price = null;

    #[Groups(["read:product"])]
    #[ORM\Column]
    private ?int $quantity = null;

    #[Groups(["read:product"])]
    #[ORM\Column]
    private ?float $weight = null;

    #[Groups(["read:product"])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $imageUrl = null;

    #[Groups(["read:product"])]
    #[ORM\Column]
    private ?bool $isAvailable = null;

    #[Groups(["read:product"])]
    #[ORM\Column]
    private ?bool $isNew = null;

    #[Groups(["read:product"])]
    #[ORM\Column]
    private ?float $averageRating = null;

    #[Groups(["read:product"])]
    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductBrand $brand = null;

    #[Groups(["read:product"])]
    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?ProductCollection $collection = null;

    #[Groups(["read:product"])]
    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductCategory $category = null;

    #[Groups(["read:product"])]
    #[ORM\ManyToMany(targetEntity: ProductAttribut::class)]
    private Collection $productAttributs;

    #[Groups(["read:product"])]
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductRating::class, orphanRemoval: true)]
    private Collection $productRating;

    public function __construct() {
        $this->productAttributs = new ArrayCollection();
        $this->productRating = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(float $price): self {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self {
        $this->quantity = $quantity;

        return $this;
    }

    public function getWeight(): ?float {
        return $this->weight;
    }

    public function setWeight(float $weight): self {
        $this->weight = $weight;

        return $this;
    }

    public function getImageUrl(): ?string {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function isIsNew(): ?bool {
        return $this->isNew;
    }

    public function setIsNew(bool $isNew): self {
        $this->isNew = $isNew;

        return $this;
    }

    public function getAverageRating(): ?float {
        return $this->averageRating;
    }

    public function isIsAvailable(): ?bool {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    public function getBrand(): ?ProductBrand {
        return $this->brand;
    }

    public function setBrand(?ProductBrand $brand): self {
        $this->brand = $brand;

        return $this;
    }

    public function getCollection(): ?ProductCollection {
        return $this->collection;
    }

    public function setCollection(?ProductCollection $collection): self {
        $this->collection = $collection;

        return $this;
    }

    public function getCategory(): ?ProductCategory {
        return $this->category;
    }

    public function setCategory(?ProductCategory $category): self {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, ProductAttribut>
     */
    public function getProductAttributs(): Collection {
        return $this->productAttributs;
    }

    public function addProductAttribut(ProductAttribut $productAttribut): self {
        if (!$this->productAttributs->contains($productAttribut)) {
            $this->productAttributs->add($productAttribut);
        }

        return $this;
    }

    public function removeProductAttribut(ProductAttribut $productAttribut): self {
        $this->productAttributs->removeElement($productAttribut);

        return $this;
    }

    /**
     * @return Collection<int, ProductRating>
     */
    public function getProductRating(): Collection {
        return $this->productRating;
    }

    public function addProductRating(ProductRating $productRating): self {
        if (!$this->productRating->contains($productRating)) {
            $this->productRating->add($productRating);
            $this->averageRating = $this->calculateAverageRating();
            $productRating->setProduct($this);
        }

        return $this;
    }

    public function removeProductRating(ProductRating $productRating): self {
        if ($this->productRating->removeElement($productRating)) {
            // set the owning side to null (unless already changed)
            if ($productRating->getProduct() === $this) {
                $productRating->setProduct(null);
            }

            $this->averageRating = $this->calculateAverageRating();
        }

        return $this;
    }

    public function calculateAverageRating(): float {
        $sum = 0;
        $count = 0;

        foreach ($this->getProductRating() as $productRating) {
            $sum += $productRating->getRating();
            $count++;
        }

        return $count > 0 ? round($sum / $count, 3) : 0.0;
    }
}
