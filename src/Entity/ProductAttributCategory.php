<?php

namespace App\Entity;

use App\Repository\ProductAttributCategoryRepository;
use App\Trait\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductAttributCategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ProductAttributCategory
{
    use TimestampableTrait;

    #[Groups(["read:data:generic"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(["read:product-attribut-category"])]
    #[ORM\Column(length: 150)]
    private ?string $name = null;

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
}
