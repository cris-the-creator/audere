<?php
declare(strict_types=1);

namespace Audere;

class InjectionBuilder
{
    private array $parameters;

    public function __construct()
    {}

    public function add($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    public function get($key): mixed
    {
        if (!array_key_exists($key, $this->parameters)) {
            return null;
        }
        return $this->parameters[$key];
    }
}