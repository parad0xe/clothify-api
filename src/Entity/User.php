<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use App\Repository\UserRepository;
use App\Trait\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: [
                "groups" => [
                    "read:data:generic",
                    "read:user",
                    "read:address"
                ]
            ]
        ),
        new Patch(
            normalizationContext: [
                'groups' => [
                    "read:data:generic",
                    "read:user",
                    "read:address"
                ]
            ]
        )
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("read:data:generic")]
    private ?int $id = null;

    #[Groups("read:user")]
    #[ORM\Column(length: 100)]
    private ?string $username = null;

    #[Groups("read:user")]
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $firstname = null;

    #[Groups("read:user")]
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $lastname = null;

    #[Groups("read:user")]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Groups("read:user")]
    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $password = null;

    #[Groups("read:user")]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Address $billingAddress = null;

    #[Groups("read:user")]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Address $deliveryAddress = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(string $username): self {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string {
        return $this->phone;
    }

    public function setPhone(?string $phone): self {
        $this->phone = $phone;
        return $this;
    }

    public function getBillingAddress(): ?Address {
        return $this->billingAddress;
    }

    public function setBillingAddress(?Address $billingAddress): self {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getDeliveryAddress(): ?Address {
        return $this->deliveryAddress;
    }

    public function setDeliveryAddress(?Address $deliveryAddress): self {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array {
        return ["ROLE_USER"];
    }

    public function eraseCredentials() {

    }

    public function getUserIdentifier(): string {
        return $this->email;
    }
}
