<?php

declare(strict_types=1);

namespace Audere;

class DependencyResolution
{
    public function __construct()
    {}

    public function fetchParameters(string $className): array
    {
        if (!class_exists($className)) {
            throw new \Exception('Class not found');
        }

        $constructorParameter = [];

        $class = new \ReflectionClass($className);
        $constructor = $class->getConstructor();
        if ($constructor && $constructor->isPublic()) {
            $constructorParameter = $this->getParameters($constructor);
        }

        return $constructorParameter;
    }

    public function resolveParameters(array $parameters)
    {
        $args = [];
        foreach ($parameters as $index => $parameter) {

            $args[] = &$value;
        }
        return $args;
    }

    private function getParameters(\ReflectionFunctionAbstract $constructor): array
    {
        $params = [];
        foreach ($constructor->getParameters() as $index => $parameter)  {
            if ($parameter->isOptional()) {
                continue;
            }

            $type = $parameter->getType();
            if (!$type) {
                continue;
            }
            if (!$type instanceof \ReflectionNamedType) {
                continue;
            }
            if ($type->isBuiltin()) {
                continue;
            }

            $params[$index] = $type->getName();
        }
        return $params;
    }
}