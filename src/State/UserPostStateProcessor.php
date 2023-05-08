<?php

namespace App\State;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserPostStateProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly PersistProcessor $processor,
        private readonly UserPasswordHasherInterface $_hasher
    ) { }

    /**
     * @param User      $data
     * @param Operation $operation
     * @param array     $uriVariables
     * @param array     $context
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []) {
        $data->setPassword(
            $this->_hasher->hashPassword($data, $data->getPassword())
        );

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
