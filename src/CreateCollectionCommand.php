<?php

namespace Nkopylov\PhpCollections;

class CreateCollectionCommand
{
    private Generator $generator;
    private string $path;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
        $this->path = $this->revealPath();
    }

    public function setCustomPath(string $path)
    {
        $this->path = $path;
    }

    public function createCollectionFile(): bool
    {
        $path = $this->path;
        if (!is_writable($path)) {
            throw new \LogicException("Can't write to $path. Please check file system permissions");
        }

        $collectionContents = $this->generator->generate();
        $fileName = sprintf("%s/%s", $path, $this->generateFileName());

        return (bool)file_put_contents($fileName, $collectionContents);
    }

    private function generateFileName(): string
    {
        return sprintf("%s.php", $this->generator->getCollectionClassName());
    }

    private function revealPath(): string
    {
        $reflectionClass = new \ReflectionClass($this->generator->getCollectableClassName());
        if ($reflectionClass->getNamespaceName() === $this->generator->getNamespace()) {
            return dirname($reflectionClass->getFileName());
        }
        return trim(str_replace('\\', '/', $this->generator->getNamespace()), '/');
    }
}
