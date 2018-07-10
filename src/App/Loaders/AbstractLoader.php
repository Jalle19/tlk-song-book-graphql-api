<?php

namespace Jalle19\Tlk\SongBook\App\Loaders;

use Jalle19\Tlk\SongBook\Resources\ResourceManager;

/**
 * Class AbstractLoader
 * @package Jalle19\Tlk\SongBook\App\Loaders
 */
abstract class AbstractLoader implements LoaderInterface
{
    /**
     * @var ResourceManager
     */
    protected $resourceManager;

    /**
     * CategoryLoader constructor.
     *
     * @param ResourceManager $resourceManager
     */
    public function __construct(ResourceManager $resourceManager)
    {
        $this->resourceManager = $resourceManager;
    }
}
