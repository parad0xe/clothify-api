<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\RequestBody;
use App\Controller\PaypalAuthorizePaymentController;
use App\Entity\Interface\UserOwnedInterface;
use App\Repository\OrderRepository;
use App\Trait\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(
            openapiContext: [
                'summary' => "Récupérer une commande à partir de sa référence"
            ],
            normalizationContext: [
                'openapi_definition_name' => "Detail",
                'groups' => [
                    "read:data:generic",
                    "read:order",
                    "read:order-item",
                    "read:product",
                    "read:product-attribut",
                    "read:product-attribut-category",
                    "read:product-brand",
                    "read:product-category",
                    "read:product-collection",
                    "read:address"
                ]
            ]
        ),
        new Post(
            uriTemplate: "/orders/checkout/paypal/authorize/{reference}",
            controller: PaypalAuthorizePaymentController::class,
            openapiContext: [
                'summary' => "Authorisation et création de la commande",
                'description' => "Permet de créer la commande après validation avec les serveurs de paypal.",
            ],
            openapi: new Operation(
                responses: [
                    Response::HTTP_CREATED => new \ApiPlatform\OpenApi\Model\Response(
                        description: "La commande est validée et enregistrée.",
                        content: new \ArrayObject([
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'isAuthorized' => ['type' => 'boolean', 'default' => "false"],
                                        'message' => ['type' => 'string'],
                                        'reference' => ['type' => 'string']
                                    ]
                                ]
                            ]
                        ])
                    )
                ],
                requestBody: new RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'orderItems' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'product' => ['type' => 'string'],
                                                'quantity' => ['type' => 'integer'],
                                                'totalCost' => ['type' => 'integer'],
                                                'productAttributs' => [
                                                    'type' => 'array',
                                                    'items' => ['type' => 'string']
                                                ],
                                            ]
                                        ],

                                    ]
                                ]
                            ]
                        ]
                    ]),
                    required: true
                )
            ),
            read: false,
            write: false,
            name: 'authorize_payment'
        )
    ]
)]
#[ApiFilter(SearchFilter::class, strategy: 'exact', properties: ["reference" => "exact"])]
class Order implements UserOwnedInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read:data:generic"])]
    #[ApiProperty(identifier: false)]
    private ?int $id = null;

    #[ORM\Column(length: 200, nullable: false)]
    #[Groups(["read:order"])]
    #[ApiProperty(identifier: true)]
    private ?string $reference = null;

    #[ORM\Column]
    #[Groups(["read:order"])]
    private ?float $totalCost = null;

    #[ORM\Column(length: 100)]
    #[Groups(["read:order"])]
    private ?string $paymentMethod = null;

    #[ORM\Column(length: 70)]
    #[Groups(["read:order"])]
    private ?string $state = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["write:order"])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'purchase', targetEntity: OrderItem::class, cascade: [
        'persist',
        'remove'
    ], orphanRemoval: true)]
    #[Groups(["read:order"])]

    #[Assert\Type("array")]
    private Collection $orderItems;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["read:order"])]
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

    public function getState(): ?string {
        return $this->state;
    }

    public function setState(string $state): self {
        $this->state = $state;

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
