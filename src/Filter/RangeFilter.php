<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Common\Filter\RangeFilterInterface;
use ApiPlatform\Doctrine\Common\Filter\RangeFilterTrait;
use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Trait\AliasableFilterTrait;
use Doctrine\ORM\QueryBuilder;

final class RangeFilter extends AbstractFilter implements RangeFilterInterface
{
    use AliasableFilterTrait;
    use RangeFilterTrait;

    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        ($this->createRealFilterInstance(\ApiPlatform\Doctrine\Orm\Filter\RangeFilter::class))
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