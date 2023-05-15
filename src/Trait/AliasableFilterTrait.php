<?php

namespace App\Trait;


use ApiPlatform\Doctrine\Common\PropertyHelperTrait;

trait AliasableFilterTrait
{
    use PropertyHelperTrait;

    protected ?array $properties;
    abstract protected function isPropertyEnabled(string $property, string $resourceClass): bool;

    protected function createRealFilterInstance(string $className) {
        return new $className(
            $this->getManagerRegistry(),
            $this->getLogger(),
            $this->getProperties(),
            $this->nameConverter
        );
    }

    protected function normalizePropertyName(string $property): string {
        if (in_array($property, $this->properties)) {
            return array_flip(array_reduce(array_keys($this->properties), function ($a, $key) {
                $a[$key] = $this->properties[$key] ?? $key;
                return $a;
            }, []))[$property];
        }

        return $property;
    }

    protected function getProperties(): ?array {
        return array_flip(array_map(function ($key) {
            return $this->properties[$key] ?? $key;
        }, array_keys($this->properties)));
    }

    protected function getRealMappedProperty(string $fromProperty, string $resourceClass): string {
        if (!$this->isPropertyEnabled($fromProperty, $resourceClass)) {
            return "";
        }

        $property = $this->properties[$fromProperty] ?? $fromProperty;

        return ($this->isPropertyMapped($property, $resourceClass))
            ? $property : "";
    }
}