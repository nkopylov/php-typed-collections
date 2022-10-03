<?php

declare(strict_types=1);

namespace Nkopylov\Test\PhpCollections;

use Nkopylov\PhpCollections\CreateCollectionCommand;
use Nkopylov\PhpCollections\Generator;
use Nkopylov\Test\PhpCollections\AnotherNamespace\ClassFromAnotherNamespace;
use Nkopylov\Test\PhpCollections\AnotherNamespace\InterfaceFromAnotherNamespace;
use Nkopylov\Test\PhpCollections\AnotherNamespace\TestParentClassFromAnotherNamespace;
use Nkopylov\Test\PhpCollections\AnotherNamespace\TraitFromAnotherNamespace;
use Nkopylov\Test\PhpCollections\HelloableInterface;
use Nkopylov\Test\PhpCollections\TestParentClass;
use PHPUnit\Framework\TestCase;

class CreateCollectionCommandTest extends TestCase
{
    private const FILENAME = __DIR__ . '/TestCollection.php';

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        unlink(self::FILENAME);
    }

    public function testCollection(): void
    {
        $generator = new Generator(
            TestClass::class,
        );

        $generator->setCollectionClassName('TestCollection');

        $command = new CreateCollectionCommand($generator);
        $command->createCollectionFile();

        $collection = TestCollection::create();

        self::assertInstanceOf(TestCollection::class, $collection);
    }
}
