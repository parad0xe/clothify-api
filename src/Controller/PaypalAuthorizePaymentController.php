<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\User;
use App\Helper\PaypalClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsController]
class PaypalAuthorizePaymentController extends AbstractController
{
    public function __construct(
        private readonly HttpClientInterface $_client,
        private readonly EntityManagerInterface $_entityManager,
        private readonly RequestStack $_requestStack
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function __invoke(string $reference): JsonResponse {
        $request = $this->_requestStack->getCurrentRequest();

        $paypalClient = new PaypalClient(
            $this->getParameter('paypal.client_id'),
            $this->getParameter('paypal.secret_id'),
            $this->_client
        );

        $newOrder = $request->attributes->get('data');

        $orderDetailResponse = $paypalClient->getOrderDetails($reference);
        if (!$orderDetailResponse) {
            return $this->_response(false, "Commande introuvable.");
        }

        $targetOrderTotalCost = floatval($orderDetailResponse['purchase_units'][0]['amount']['value']);
        if (!$this->_validateOrder($newOrder, $targetOrderTotalCost)) {
            return $this->_response(false, "Des informations semblent invalides.");
        }

        $authorizationResponse = $paypalClient->authorizeOrder($reference);
        if (!$authorizationResponse) {
            return $this->_response(false, "La commande n'as pas été authorisée.");
        }

        $authorizationId = $authorizationResponse['id'];

        /** @var User $user */
        $user = $this->getUser();

        $newOrder->setPaymentMethod("PAYPAL")
            ->setState("APPROUVED")
            ->setReference($authorizationId)
            ->setTotalCost($targetOrderTotalCost)
            ->setShippingAddress((new Address())
                ->setAddress($user->getDeliveryAddress()->getAddress())
                ->setCity($user->getDeliveryAddress()->getCity())
                ->setCountry($user->getDeliveryAddress()->getCountry())
                ->setPostalCode($user->getDeliveryAddress()->getPostalCode()))
            ->setUser($user);

        $this->_entityManager->persist($newOrder);
        $this->_entityManager->flush();

        return $this->_response(
            true,
            "La commande à été approuvé avec succès.",
            $newOrder->getReference()
        );
    }

    private function _validateOrder(Order $order, float $targetTotalCost): bool {
        $orderTotalCost = floatval(number_format(array_reduce($order->getOrderItems()->toArray(), function (
            $total,
            OrderItem $orderItem
        ) {
            $total += $orderItem->getProduct()->getPrice() * $orderItem->getQuantity();
            return $total;
        }, 0.0), 2));

        return $orderTotalCost === $targetTotalCost;
    }

    private function _response(
        bool $isAuthorized,
        string $message = "",
        string $reference = null
    ): JsonResponse {
        return $this->json([
            'isAuthorized' => $isAuthorized,
            "message" => $message,
            "reference" => $reference
        ]);
    }
}
