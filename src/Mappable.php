<?php

declare(strict_types=1);

namespace Nkopylov\PhpCollections;

interface Mappable
{
    /**
     * Return a callback function to map collection entities by id
     * @return callable
     */
    public static function getMapperFunction(): callable;
}
