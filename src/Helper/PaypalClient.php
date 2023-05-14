<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PaypalClient
{
    private readonly string $_clientId;
    private readonly string $_secretId;

    public function __construct(
        string $clientId,
        string $secretId,
        private readonly HttpClientInterface $_client
    ) {
        $this->_clientId = $clientId;
        $this->_secretId = $secretId;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function authorizeOrder(string $orderId): array|null {
        $accessToken = $this->_getAccessToken();

        if(!$accessToken) {
            return null;
        }

        $authorizeResponse = $this->_client->request('POST', "https://api-m.sandbox.paypal.com/v2/checkout/orders/$orderId/authorize", [
            "headers" => [
                "Authorization" => "Bearer $accessToken",
                "Content-Type" => "application/json"
            ]
        ]);

        return ($authorizeResponse->getStatusCode() === Response::HTTP_CREATED)
            ? json_decode($authorizeResponse->getContent(), true)
            : null;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getOrderDetails(string $orderId): array|null {
        $accessToken = $this->_getAccessToken();

        if(!$accessToken) {
            return null;
        }

        $orderDetailResponse = $this->_client->request('GET', "https://api-m.sandbox.paypal.com/v2/checkout/orders/$orderId", [
            "headers" => [
                "Authorization" => "Bearer $accessToken",
                "Content-Type" => "application/json"
            ]
        ]);

        return ($orderDetailResponse->getStatusCode() === Response::HTTP_OK)
            ? json_decode($orderDetailResponse->getContent(), true)
            : null;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function _getAccessToken(): string|null {
        $tokenResponse = $this->_client->request('POST', "https://api-m.sandbox.paypal.com/v1/oauth2/token", [
            "auth_basic" => [$this->_clientId, $this->_secretId],
            "headers" => ["Content-Type" => "application/x-www-form-urlencoded"],
            'body' => ['grant_type' => 'client_credentials']
        ]);

        $jsonResponse = json_decode($tokenResponse->getContent(), true);

        return (array_key_exists("access_token", $jsonResponse))
            ? $jsonResponse['access_token']
            : null;
    }

}