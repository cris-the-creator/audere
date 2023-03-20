<?php

declare(strict_types=1);

namespace Audere;

class InjectionBuilder
{
    private array $parameters = [];

    /**
     * @todo Import parameters from yaml file
     */
    public function __construct() {}

    public function add($key, $value): void
    {
        $this->parameters[$key] = $value;
    }

    public function get(string $key): mixed
    {
        if (!array_key_exists($key, $this->parameters)) {
            return null;
        }
        return $this->parameters[$key];
    }
}