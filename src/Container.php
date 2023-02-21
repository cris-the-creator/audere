<?php
declare(strict_types=1);

namespace Audere;

class Container
{
    private array $parameters;
    private DependencyResolution $dependencyResolution;

    public function __construct()
    {
        $this->dependencyResolution = new DependencyResolution();
    }

    public function get(string $className): mixed
    {
        $parameters = $this->fetchParameters($className);

        $this->resolveParameters($parameters);
    }

    private function resolveParameters(array $parameters): void
    {
        $this->dependencyResolution->resolveParameters($parameters);
    }

    private function fetchParameters(string $className): array
    {
        if (! array_key_exists($className, $this->parameters)) {
            $this->parameters[$className] = $this->dependencyResolution->fetchParameters($className);
        }

        return $this->parameters[$className] ;
    }
}