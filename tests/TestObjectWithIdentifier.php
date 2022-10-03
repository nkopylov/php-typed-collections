<?php
namespace Nkopylov\Test\PhpCollections;

use Nkopylov\PhpCollections\ObjectWithIdentifier;

class TestObjectWithIdentifier implements ObjectWithIdentifier
{
    private int $id;

    public function __construct(int $id) {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
