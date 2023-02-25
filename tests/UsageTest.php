<?php

require_once __DIR__ . '/FakeClass.php';
require_once __DIR__ . '/FakeDependencyClass.php';
require_once __DIR__ . '/FakeAttributeClass.php';

class UsageTest extends \PHPUnit\Framework\TestCase
{
    private static ?Audere\Container $container;

    function setUp(): void
    {
        $builder = new \Audere\InjectionBuilder();
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
        $this->expectException(\Audere\Exception\ClassException::class);
        $this->expectExceptionMessage('Class not found');

        self::$container->get('NonExistingClass');
    }

    function testAttributeInjection()
    {
        $fakeClass = self::$container->get('FakeAttributeClass');

        $this->assertEquals(FakeAttributeClass::class, $fakeClass::class);
        $this->assertEquals('Hello World', $fakeClass->getGreeting());
    }

    function testClassInjection()
    {
        $fakeClass = self::$container->get('FakeClass');

        $this->assertEquals(FakeClass::class, $fakeClass::class);
        $this->assertEquals(FakeDependencyClass::class, $fakeClass->getDependencyClass()::class);
    }
}