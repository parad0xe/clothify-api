<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Repository\ProductAttributRepository;
use App\Trait\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductAttributRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                'groups' => [
                    'read:data:generic',
                    'read:product-attribut'
                ]
            ]
        )
    ]
)]
class ProductAttribut
{
    use TimestampableTrait;

    #[Groups(["read:data:generic"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["read:product-attribut"])]
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[Groups(["read:product-attribut"])]
    #[ORM\Column(length: 150)]
    private ?string $value = null;

    #[Groups(["read:product-attribut"])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProductAttributCategory $productAttributCategory = null;

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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getProductAttributCategory(): ?ProductAttributCategory
    {
        return $this->productAttributCategory;
    }

    public function setProductAttributCategory(?ProductAttributCategory $productAttributCategory): self
    {
        $this->productAttributCategory = $productAttributCategory;

        return $this;
    }
}
