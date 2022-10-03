<?php

declare(strict_types=1);

namespace Nkopylov\Test\PhpCollections;

use Nkopylov\PhpCollections\Generator;
use Nkopylov\Test\PhpCollections\AnotherNamespace\ClassFromAnotherNamespace;
use Nkopylov\Test\PhpCollections\AnotherNamespace\InterfaceFromAnotherNamespace;
use Nkopylov\Test\PhpCollections\AnotherNamespace\TestParentClassFromAnotherNamespace;
use Nkopylov\Test\PhpCollections\AnotherNamespace\TraitFromAnotherNamespace;
use Nkopylov\Test\PhpCollections\HelloableInterface;
use Nkopylov\Test\PhpCollections\TestParentClass;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    use TestTrait, TraitFromAnotherNamespace;

    private static array $createdFiles = [];

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        foreach (self::$createdFiles as $file) {
            unlink($file);
        }
    }

    public function testCollection(): void
    {
        $generator = new Generator(
            TestClass::class,
        );
        $collection = $this->generateCollectionByGenerator($generator);
        $collection->add(new TestClass(1));

        self::assertEquals($collection->first()->getId(), 1);
    }

    public function testCollectionAddTrait(): void
    {
        $generator = new Generator(
            TestClass::class,
        );
        $generator->addTrait(TestTrait::class);
        $collection = $this->generateCollectionByGenerator($generator);
        self::assertEquals($collection->sayHello(), $this->sayHello());
    }

    public function testCollectionAddTraitFromAnotherNamespace(): void
    {
        $generator = new Generator(
            TestClass::class,
        );
        $generator->addTrait(TraitFromAnotherNamespace::class);
        $collection = $this->generateCollectionByGenerator($generator);
        self::assertEquals($collection->sayHelloFromAnotherNamespace(), $this->sayHelloFromAnotherNamespace());
    }

    public function testCollectionAddInterface(): void
    {
        $generator = new Generator(
            TestClass::class,
        );
        $generator->addInterface(HelloableInterface::class);
        $generator->addTrait(TestTrait::class);
        $collection = $this->generateCollectionByGenerator($generator);
        self::assertInstanceOf(HelloableInterface::class, $collection);
    }

    public function testCollectionAddInterfaceFromAnotherNamespace(): void
    {
        $generator = new Generator(
            TestClass::class,
        );
        $generator->addInterface(InterfaceFromAnotherNamespace::class);
        $generator->addTrait(TraitFromAnotherNamespace::class);
        $collection = $this->generateCollectionByGenerator($generator);
        self::assertInstanceOf(InterfaceFromAnotherNamespace::class, $collection);
    }

    public function testCollectionParentClass(): void
    {
        $generator = new Generator(
            TestClass::class,
        );
        $generator->setParentClass(TestParentClass::class);
        $collection = $this->generateCollectionByGenerator($generator);
        self::assertInstanceOf(TestParentClass::class, $collection);
    }

    public function testCollectionParentClassFromAnotherNamespace(): void
    {
        $generator = new Generator(
            TestClass::class,
        );
        $generator->setParentClass(TestParentClassFromAnotherNamespace::class);
        $collection = $this->generateCollectionByGenerator($generator);
        self::assertInstanceOf(TestParentClassFromAnotherNamespace::class, $collection);
    }

    public function testCollectionWithCustomMapper(): void
    {
        $generator = new Generator(
            TestObjectWithMappable::class,
        );
        $collection = $this->generateCollectionByGenerator($generator);
        $object = new TestObjectWithMappable(15);
        $collection->add($object);
        self::assertEquals($object, $collection->get($object->customId));
    }

    public function testCollectionWithIdentifier(): void
    {
        $generator = new Generator(
            TestObjectWithIdentifier::class,
        );
        $collection = $this->generateCollectionByGenerator($generator);
        $object = new TestObjectWithIdentifier(23);
        $collection->add($object);
        self::assertEquals($object, $collection->get($object->getId()));
    }

    public function testCollectionWithoutMapper(): void
    {
        $generator = new Generator(
            TestClass::class,
        );
        $collection = $this->generateCollectionByGenerator($generator);
        $object1 = new TestClass(1);
        $object2 = new TestClass(2);
        $collection->add($object1);
        $collection->add($object2);

        self::assertEquals($object1, $collection->get(0));
        self::assertEquals($object2, $collection->get(1));
    }

    public function testCollectionWithCustomTemplate(): void
    {
        $generator = new Generator(
            TestClass::class,
        );
        $generator->setCustomTemplate(__DIR__ . "/custom_template.template");
        $generator->resetInterfaces();
        $collection = $this->generateCollectionByGenerator($generator);
        self::assertEquals("Hello from the custom template!", $collection->sayHello());
    }

    public function testCollectionSetCustomNamespace(): void
    {
        $generator = new Generator(
            ClassFromAnotherNamespace::class,
        );
        $generator->setCustomNamespace(__NAMESPACE__);
        $collection = $this->generateCollectionByGenerator($generator);
        $collection->add(new ClassFromAnotherNamespace(1));

        self::assertEquals($collection->first()->getId(), 1);
    }

    private function generateCollectionByGenerator(Generator $generator)
    {
        $collectionName = "TestCollection_" . debug_backtrace()[1]['function'];
        $fileName = __DIR__ . "/$collectionName.php";
        $generator->setCollectionClassName($collectionName);
        self::$createdFiles[] = $fileName;
        $newContent = $generator->generate();
        file_put_contents($fileName, $newContent);
        $collectionName = __NAMESPACE__ . "\\" . $collectionName;
        return $collectionName::create();
    }
}
