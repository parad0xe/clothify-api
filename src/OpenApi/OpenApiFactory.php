<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use Symfony\Component\HttpFoundation\Response;

class OpenApiFactory implements OpenApiFactoryInterface
{

    public function __construct(private readonly OpenApiFactoryInterface $_decorated) {
    }

    public function __invoke(array $context = []): OpenApi {
        $openApi = $this->_decorated->__invoke($context);

        $this->updateDescriptionOfLoginPathItem($openApi, '/api/login');

        return $openApi;
    }

    private function updateDescriptionOfLoginPathItem(OpenApi $openApi, string $loginPath) {
        $loginPathItem = $openApi->getPaths()->getPath($loginPath);

        $openApi->getPaths()->addPath(
            $loginPath,
            $loginPathItem->withPost(
                $loginPathItem->getPost()
                    ->withResponses([
                        Response::HTTP_OK => [
                            'description' => 'Token utilisateur crée.',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'token' => [
                                                'readOnly' => true,
                                                'type' => 'string',
                                                'nullable' => false,
                                            ],
                                            'id' => [
                                                'readOnly' => true,
                                                'type' => 'integer',
                                                'nullable' => false,
                                            ],
                                            'firstname' => [
                                                'readOnly' => true,
                                                'type' => 'string',
                                                'nullable' => false,
                                            ],
                                            'lastname' => [
                                                'readOnly' => true,
                                                'type' => 'string',
                                                'nullable' => false,
                                            ],
                                            'expiresAt' => [
                                                'readOnly' => true,
                                                'type' => 'string',
                                                'nullable' => false,
                                            ]
                                        ],
                                        'required' => [
                                            'token',
                                            'id',
                                            'firstname',
                                            'lastname',
                                            'expiresAt'
                                        ],
                                    ],
                                ],
                            ]
                        ]
                    ])
                    ->withSummary('Création du token Utilisateur.')
                    ->withRequestBody(
                        $loginPathItem->getPost()
                            ->getRequestBody()
                            ->withDescription("Identifiant de connexion")
                    )
            )
        );
    }
}