<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Common\Filter\BooleanFilterTrait;
use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Trait\AliasableFilterTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\QueryBuilder;

final class BooleanFilter extends AbstractFilter
{
    use AliasableFilterTrait;
    use BooleanFilterTrait;

    public const DOCTRINE_BOOLEAN_TYPES = [
        Types::BOOLEAN => true,
    ];

    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        ($this->createRealFilterInstance(\ApiPlatform\Doctrine\Orm\Filter\BooleanFilter::class))
            ->filterProperty(
                $this->getRealMappedProperty($property, $resourceClass),
                $value,
                $queryBuilder,
                $queryNameGenerator,
                $resourceClass,
                $operation,
                $context
            );
    }
}