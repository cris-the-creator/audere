<?php
declare(strict_types=1);

class FakeClass
{
    public function __construct(private FakeDependencyClass $fakeDependencyClass)
    {
    }

    public function getDependencyClass(): FakeDependencyClass
    {
        return $this->fakeDependencyClass;
    }
}