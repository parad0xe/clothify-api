<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Carbon\Carbon;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTSubscriber implements EventSubscriberInterface
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack) {
        $this->requestStack = $requestStack;
    }

    public function onJWTCreated(JWTCreatedEvent $event): void {
        $request = $this->requestStack->getCurrentRequest();

        $user = $event->getUser();

        if(!$user instanceof User) {
            return;
        }

        $payload = $event->getData();
        $payload['id'] = $user->getId();
        $payload['ip'] = $request->getClientIp();

        $event->setData($payload);
    }

    public function onJWTDecoded(JWTDecodedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $payload = $event->getPayload();

        if (!isset($payload['ip']) || $payload['ip'] !== $request->getClientIp()) {
            $event->markAsInvalid();
        }
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event) {
        $data = $event->getData();
        $user = $event->getUser();

        if(!$user instanceof User) {
            return;
        }

        $data['id'] = $user->getId();
        $data['firstname'] = $user->getFirstname();
        $data['lastname'] = $user->getLastname();
        $data['expiresAt'] = Carbon::now(new \DateTimeZone("Europe/Paris"))->add('hour', 1);

        $event->setData($data);
    }

    public static function getSubscribedEvents(): array {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onJWTCreated',
            'lexik_jwt_authentication.on_jwt_decoded' => 'onJWTDecoded',
            'lexik_jwt_authentication.on_authentication_success' => 'onAuthenticationSuccessResponse',
        ];
    }
}
