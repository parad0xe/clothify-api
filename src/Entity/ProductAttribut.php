<?php

namespace App\Entity;

use App\Repository\ProductAttributRepository;
use App\Trait\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductAttributRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ProductAttribut
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["product:generic"])]
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[Groups(["product:generic"])]
    #[ORM\Column(length: 150)]
    private ?string $value = null;

    #[Groups(["product:generic"])]
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
