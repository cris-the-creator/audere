# audere &middot; ![GitHub Actions](https://github.com/pengboomouch/audere/actions/workflows/php.yml/badge.svg?event=push) [![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/pengboomouch/regulus/LICENSE)

Automatic Dependency Resolution

### Install
```
composer require pengboomouch/audere
```

### Basic usage
```php
$myClass = $container->get('MyClass');

$myClass->doSomethingUseful();
```

### With attribute Injection
```php
use Audere\Inject;

class MyAttributeClass
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

$builder = new InjectionBuilder();
$builder->add('say.hello', 'Hello World');

$container = new Audere\Container($builder);
$myAttributeClass = $container->get('MyAttributeClass');
echo $myAttributeClass->getGreeting(); //prints: Hello World
```