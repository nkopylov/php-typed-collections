<?php

namespace Nkopylov\Test\PhpCollections;

use Nkopylov\PhpCollections\Mappable;

class TestObjectWithMappable implements Mappable
{
    public int $customId;

    public function __construct(int $customId) {
        $this->customId = $customId;
    }

    public static function getMapperFunction(): callable
    {
        return static fn(self $object) => $object->customId;
    }
}
