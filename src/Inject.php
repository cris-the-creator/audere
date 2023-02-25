<?php
declare(strict_types=1);

namespace Audere;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::TARGET_PARAMETER)]
class Inject
{

    private mixed $name;
    public function __construct(string|array|null $name = null)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}