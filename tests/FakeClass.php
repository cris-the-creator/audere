<?php

declare(strict_types=1);

class FakeClass
{
    public function __construct(private readonly FakeDependencyClass $fakeDependencyClass)
    {}

    public function getDependencyClass(): FakeDependencyClass
    {
        return $this->fakeDependencyClass;
    }
}