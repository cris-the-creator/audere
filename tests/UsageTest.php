<?php

class UsageTest extends \PHPUnit\Framework\TestCase
{
    function initiliaizeTest()
    {
        $container = new Audere\Container();
        $testClass = $container->get('TestClass');
    }
}