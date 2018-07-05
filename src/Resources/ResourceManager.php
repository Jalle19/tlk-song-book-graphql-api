<?php

namespace Jalle19\Tlk\SongBook\Resources;

/**
 * Class ResourceManager
 * @package Jalle19\Tlk\SongBook\Resources
 */
class ResourceManager
{

    /**
     * @var string
     */
    private $basePath;

    /**
     * ResourceManager constructor.
     */
    public function __construct()
    {
        $this->basePath = __DIR__ . '/../../resources';
    }

    /**
     * @param string $relativePath
     *
     * @return string
     */
    public function getResourceAsString(string $relativePath): string
    {
        $contents = \file_get_contents($this->createAbsolutePath($relativePath));

        if ($contents === false) {
            throw new \RuntimeException('Failed to get contents from file');
        }

        return $contents;
    }

    /**
     * @param string $relativePath
     *
     * @return array
     */
    public function getResourceAsArray(string $relativePath): array
    {
        return include $this->createAbsolutePath($relativePath);
    }

    /**
     * @param string $relativePath
     *
     * @return string
     */
    private function createAbsolutePath(string $relativePath): string
    {
        $absolutePath = $this->basePath . '/' . $relativePath;

        if (!\file_exists($absolutePath)) {
            throw new \RuntimeException('Resource file does not exist');
        }

        return $absolutePath;
    }
}
