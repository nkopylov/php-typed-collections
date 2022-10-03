<?php

namespace Nkopylov\Test\PhpCollections\AnotherNamespace;

trait TraitFromAnotherNamespace
{
    public function sayHelloFromAnotherNamespace(): string
    {
        return "Hello from another namespace!";
    }
}
