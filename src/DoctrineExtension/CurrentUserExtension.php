<?php

namespace App\DoctrineExtension;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Interface\UserOwnedInterface;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use ReflectionException;
use Symfony\Bundle\SecurityBundle\Security;

class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public function __construct(private readonly Security $_security) { }

    /**
     * @throws ReflectionException
     */
    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        $this->addWhere($resourceClass, $queryBuilder);
    }

    /**
     * @throws ReflectionException
     */
    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        Operation $operation = null,
        array $context = []
    ): void {
        $this->addWhere($resourceClass, $queryBuilder);
    }

    /**
     * @throws ReflectionException
     */
    private function addWhere(string $resourceClass, QueryBuilder $queryBuilder) {

        if($resourceClass === User::class) {
            $userId = ($this->_security->getUser() !== null) ? $this->_security->getUser()->getId() : -1;
            $alias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere("$alias.id = :currentUserId")
                ->setParameter("currentUserId", $userId);
            return;
        }

        $reflection = new \ReflectionClass($resourceClass);
        if($reflection->implementsInterface(UserOwnedInterface::class)) {
            $alias = $queryBuilder->getRootAliases()[0];
            $queryBuilder->andWhere("$alias.user = :currentUser")
                ->setParameter("currentUser", $this->_security->getUser());
        }
    }
}