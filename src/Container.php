<?php
declare(strict_types=1);

namespace Audere;

class Container
{
    private array $parameters;
    private DependencyResolution $dependencyResolution;

    public function __construct(?InjectionBuilder $builder = null)
    {
        $this->parameters = [];
        $this->dependencyResolution = new DependencyResolution($builder);
    }

    public function get(string $className): mixed
    {
        $parameters = $this->fetchParameters($className);

        $args = $this->resolveParameters($parameters);

        return $this->buildClass($className, $args);
    }

    private function buildClass($className, $args): mixed
    {
        return new $className(...$args);
    }

    private function resolveParameters(array $parameters): array
    {
        return $this->dependencyResolution->resolveParameters($parameters);
    }

    private function fetchParameters(string $className): array
    {
        if (! array_key_exists($className, $this->parameters)) {
            $this->parameters[$className] = $this->dependencyResolution->fetchParameters($className);
        }

        return $this->parameters[$className] ;
    }
}