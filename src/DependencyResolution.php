<?php

declare(strict_types=1);

namespace Audere;

use Audere\Exception\ClassException;

class DependencyResolution
{
    public function __construct(private readonly ?InjectionBuilder $builder = null)
    {}

    /**
     * @throws ClassException
     */
    public function fetchParameters(string $className): array
    {
        if (!class_exists($className)) {
            throw new ClassException('Class not found');
        }

        $constructorParameter = [];

        $class = new \ReflectionClass($className);
        $constructor = $class->getConstructor();
        if ($constructor && $constructor->isPublic()) {
            $constructorParameter = $this->getParameters($constructor);
        }

        return $constructorParameter;
    }

    /**
     * @throws ClassException
     */
    public function resolveParameters(array $parameters): array
    {
        $args = [];
        foreach ($parameters as $index => $parameter) {
            // Resolve class
            if (is_string($parameter))  {
                $args[$index] = $this->resolveClass($parameter);
            }

            // Resolve Injection
            if ($parameter instanceof Inject) {
                $args[$index] = $this->resolveInjection($parameter->getName());
            }

        }
        return $args;
    }

    private function resolveInjection(string $parameter): mixed
    {
        return $this->builder->get($parameter);
    }

    /**
     * @param string $className
     * @return object
     * @throws ClassException
     */
    private function resolveClass(string $className): object
    {
        if (!class_exists($className)) {
            throw new ClassException('Class could not be resolved.');
        }
        return new $className();
    }

    private function getParameters(\ReflectionFunctionAbstract $constructor): array
    {
        $params = [];
        foreach ($constructor->getParameters() as $index => $parameter)  {
            if ($parameter->isOptional()) {
                continue;
            }

            foreach ($parameter->getAttributes() as $attribute) {
                $params[$index] = $attribute->newInstance();
            }

            $type = $parameter->getType();
            if (!$type) {
                continue;
            }
            if (!$type instanceof \ReflectionNamedType) {
                $this->getInjectParameter($parameter);
            }
            if ($type->isBuiltin()) {
                continue;
            }

            $params[$index] = $type->getName();
        }

        return $params;
    }
}