<?php

declare(strict_types=1);

use Audere\Inject;

class FakeAttributeClass
{
    private string $sayHello;

    public function __construct(
        #[Inject('say.hello')] $sayHello
    ) {
        $this->sayHello = $sayHello;
    }

    public function getGreeting(): string
    {
        return $this->sayHello;
    }
}