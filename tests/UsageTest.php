<?php

use Audere\Exception\ClassException;
use Audere\InjectionBuilder;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/FakeClass.php';
require_once __DIR__ . '/FakeDependencyClass.php';
require_once __DIR__ . '/FakeAttributeClass.php';

class UsageTest extends TestCase
{
    private static ?Audere\Container $container;

    function setUp(): void
    {
        $builder = new InjectionBuilder();
        $builder->add('say.hello', 'Hello World');
        $builder->add('counter', 2);

        self::$container = new Audere\Container($builder);
    }

    function tearDown(): void
    {
        self::$container = null;
    }

    function testInit()
    {
        $this->expectException(ClassException::class);
        $this->expectExceptionMessage('Class not found');

        self::$container->get('NonExistingClass');
    }

    /**
     * @throws ClassException
     */
    function testAttributeInjection()
    {
        $fakeClass = self::$container->get('FakeAttributeClass');

        $this->assertEquals(FakeAttributeClass::class, $fakeClass::class);
        $this->assertEquals('Hello World', $fakeClass->getGreeting());
    }

    /**
     * @throws ClassException
     */
    function testClassInjection()
    {
        $fakeClass = self::$container->get('FakeClass');

        $this->assertEquals(FakeClass::class, $fakeClass::class);
        $this->assertEquals(FakeDependencyClass::class, $fakeClass->getDependencyClass()::class);
    }
}