<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Translation\TranslatorInterface;

class ApiPlatformTranslationListener implements EventSubscriberInterface
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }

    public function onKernelResponse(ResponseEvent $event) {
        $response = $event->getResponse();
        $data = json_decode($response->getContent(), true);

        if (isset($data['hydra:title'])) {
            $data['hydra:title'] = $this->translator->trans($data['hydra:title'], domain: 'api-response');
            $data['hydra:description'] = $this->translator->trans($data['hydra:description'], domain: 'api-response');
        }

        $translatedContent = json_encode($data);
        $response->setContent($translatedContent);
    }

    public static function getSubscribedEvents(): array {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse'
        ];
    }
}
