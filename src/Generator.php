<?php

declare(strict_types=1);

namespace Nkopylov\PhpCollections;

class Generator
{
    private string $template = __DIR__ . "/templates/collection.template";

    private string $collectableClass;

    private string $namespace;
    private string $parentClass;
    private array $interfaces = [
        \Iterator::class,
        \ArrayAccess::class,
    ];
    private array $traits = [];
    private string $collectionClassName;

    private string $mapperFunction;

    public function __construct(string $collectableClass)
    {
        $this->collectableClass = $collectableClass;

        $reflectionClass = new \ReflectionClass($collectableClass);
        $this->namespace = $reflectionClass->getNamespaceName();
        $this->collectionClassName = $reflectionClass->getName() . "Collection";

        if ($reflectionClass->implementsInterface(Mappable::class)) {
            $this->mapperFunction = "CollectionEntity::getMapperFunction()";
        } elseif ($reflectionClass->implementsInterface(ObjectWithIdentifier::class)) {
            $this->mapperFunction = 'fn($object) => $object->getId()';
        } else {
            $this->mapperFunction = 'function() {static $counter = 0; return $counter++;}';
        }
    }

    public function setCustomTemplate(string $template)
    {
        if (!file_exists($template)) {
            throw new \InvalidArgumentException("Template file $template does not exists");
        }

        $this->template = $template;
    }

    public function setCollectionClassName(string $collectionClassName)
    {
        $this->collectionClassName = $collectionClassName;
    }

    public function setCustomNamespace(string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function setParentClass(string $parentClass)
    {
        if (class_exists($parentClass)) {
            $this->parentClass = $parentClass;
        } else {
            throw new \InvalidArgumentException("Parent class $parentClass does not exists");
        }
    }

    public function addInterface(string $interface): void
    {
        if (interface_exists($interface)) {
            $this->interfaces[] = $interface;
        } else {
            throw new \InvalidArgumentException("Interface $interface does not exists");
        }
    }

    public function resetInterfaces(): void
    {
        $this->interfaces = [];
    }

    public function addTrait(string $trait): void
    {
        if (trait_exists($trait)) {
            $this->traits[] = $trait;
        } else {
            throw new \InvalidArgumentException("Trait $trait does not exists");
        }
    }

    public function generate(): string
    {
        $templateContents = file_get_contents($this->template);
        $hashSum = md5($templateContents);

        $substitutions = [
            "{{ classDefinition }}" => $this->generateClassDefinition(),
            "{{ mapBy }}" => $this->mapperFunction,
            "{{ generationTime }}" => $this->getGenerationTime(),
            "{{ hashSum }}" => $hashSum,
            "{{ namespace }}" => $this->namespace,
            "{{ collectableClass }}" => $this->collectableClass,
        ];

        return str_replace(array_keys($substitutions), array_values($substitutions), $templateContents);
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function getCollectionClassName(): string
    {
        return $this->collectionClassName;
    }

    public function getCollectableClassName(): string
    {
        return $this->collectableClass;
    }

    private function generateClassDefinition(): string
    {
        $classDefinition = "class $this->collectionClassName";
        if (!empty($this->parentClass)) {
            $classDefinition .= sprintf(
                " extends %s",
                $this->removeNamespaceFromIdentifierIfNeeded($this->parentClass)
            );
        }

        if (!empty($this->interfaces)) {
            $interfaces = array_map(
                fn($interface) => $this->removeNamespaceFromIdentifierIfNeeded($interface),
                $this->interfaces
            );
            $classDefinition .= " implements " . implode(', ', $interfaces);
        }

        $classDefinition .= " {\n";

        if (!empty($this->traits)) {
            $traits = array_map(
                fn($trait) => $this->removeNamespaceFromIdentifierIfNeeded($trait),
                $this->traits
            );

            $classDefinition .= sprintf("\tuse %s;\n", implode(", ", $traits));
        }

        return $classDefinition;
    }

    private function removeNamespaceFromIdentifierIfNeeded(string $objectName): string
    {
        $isInTheSameNamespace = substr_count($objectName, $this->namespace) > 0;
        $objectName = str_replace($this->namespace, "", $objectName);
        return $isInTheSameNamespace ? trim($objectName, '\\') : "\\" . $objectName;
    }

    private function getGenerationTime(): string
    {
        return (new \DateTime())->format("Y-m-d H:i:s");
    }
}
