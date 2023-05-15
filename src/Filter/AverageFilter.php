<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Common\Filter\RangeFilterInterface;
use ApiPlatform\Doctrine\Common\Filter\RangeFilterTrait;
use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Trait\AliasableFilterTrait;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Exception;
use InvalidArgumentException;

final class AverageFilter extends AbstractFilter implements RangeFilterInterface
{
    use RangeFilterTrait;
    use AliasableFilterTrait;

    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        $values = (array) $value;

        $realMappedProperty = $this->getRealMappedProperty($property, $resourceClass);
        if (!$realMappedProperty) {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];
        $field = $realMappedProperty;

        foreach ($values as $operator => $rangeValue) {
            $this->addWhere(
                $alias,
                $field,
                $operator,
                $rangeValue,
                $realMappedProperty,
                $resourceClass,
                $queryBuilder,
                $queryNameGenerator
            );
        }
    }

    protected function addWhere(
        string $alias,
        string $field,
        string $operator,
        string $rangeValue,
        string $property,
        string $resourceClass,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator
    ): void {
        $valueParameter = $queryNameGenerator->generateParameterName($field);

        $averageQuery = $this->generateAverageQuery(
            $property,
            $alias,
            $queryBuilder,
            $queryNameGenerator,
            $resourceClass
        );

        switch ($operator) {
            case self::PARAMETER_BETWEEN:
                $rangeValue = explode('..', $rangeValue);
                $rangeValue = $this->normalizeBetweenValues($rangeValue);

                if (null === $rangeValue) {
                    return;
                }

                $averageQuery_2 = $this->generateAverageQuery(
                    $property,
                    $alias,
                    $queryBuilder,
                    $queryNameGenerator,
                    $resourceClass
                );

                if ($rangeValue[0] === $rangeValue[1]) {
                    $queryBuilder
                        ->andWhere(sprintf(':%s_1 <= (%s)', $valueParameter, $averageQuery))
                        ->setParameter($valueParameter . "_1", $rangeValue[0])
                        ->andWhere(sprintf(':%s_2 > (%s)', $valueParameter, $averageQuery_2))
                        ->setParameter($valueParameter . "_2", $rangeValue[0] + 1);

                    return;
                }

                $queryBuilder
                    ->andWhere(sprintf(':%s_1 <= (%s)', $valueParameter, $averageQuery))
                    ->setParameter($valueParameter . "_1", $rangeValue[0])
                    ->andWhere(sprintf(':%s_2 >= (%s)', $valueParameter, $averageQuery_2))
                    ->setParameter($valueParameter . "_2", $rangeValue[1]);

                break;
            case self::PARAMETER_GREATER_THAN:
            case self::PARAMETER_GREATER_THAN_OR_EQUAL:
            case self::PARAMETER_LESS_THAN:
            case self::PARAMETER_LESS_THAN_OR_EQUAL:
                $rangeValue = $this->normalizeValue($rangeValue, $operator);
                if (null === $rangeValue) {
                    return;
                }

                $queryBuilder
                    ->andWhere(sprintf(':%s %s (%s)', $valueParameter, $this->_normalizeOperator($operator), $averageQuery))
                    ->setParameter($valueParameter, $rangeValue);

                break;
        }
    }

    private function _normalizeOperator(string $operator): string {
        return match ($operator) {
            self::PARAMETER_GREATER_THAN => "<",
            self::PARAMETER_GREATER_THAN_OR_EQUAL => "<=",
            self::PARAMETER_LESS_THAN => ">",
            self::PARAMETER_LESS_THAN_OR_EQUAL => ">=",
            default => throw new InvalidArgumentException(sprintf('Invalid operator: %s', $operator)),
        };
    }

    private function generateAverageQuery(
        string $property,
        string $alias,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass
    ): QueryBuilder {
        $contextAlias = $alias;
        $contextField = $property;
        $contextRootAlias = $queryNameGenerator->generateParameterName($queryBuilder->getRootAliases()[0]);

        $averageQueryBuilder = $queryBuilder->getEntityManager()->createQueryBuilder()
            ->from(
                $queryBuilder->getDQLPart('from')[0]->getFrom(),
                $contextRootAlias
            );

        if ($this->isPropertyNested($property, $resourceClass)) {
            [$contextAlias, $contextField] = $this->addJoinsForNestedProperty(
                $property,
                $contextRootAlias,
                $averageQueryBuilder,
                $queryNameGenerator,
                $resourceClass,
                Join::INNER_JOIN
            );
        }

        $averageQueryBuilder
            ->select($averageQueryBuilder->expr()->avg("$contextAlias.$contextField"))
            ->where("$contextRootAlias.id = $alias.id");

        return $averageQueryBuilder;
    }
}