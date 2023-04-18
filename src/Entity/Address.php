<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use App\Trait\TimestampableTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Address
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("read:data:generic")]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups("read:address")]
    private ?string $address = null;

    #[ORM\Column(length: 150)]
    #[Groups("read:address")]
    private ?string $city = null;

    #[ORM\Column(length: 150)]
    #[Groups("read:address")]
    private ?string $country = null;

    #[ORM\Column]
    #[Groups("read:address")]
    private ?string $postalCode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }
}
