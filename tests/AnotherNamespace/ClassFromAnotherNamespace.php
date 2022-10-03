<?php
namespace Nkopylov\Test\PhpCollections\AnotherNamespace;

use Nkopylov\PhpCollections\ObjectWithIdentifier;

class ClassFromAnotherNamespace implements ObjectWithIdentifier
{
    private int $id;
    public function __construct(int $id) {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
