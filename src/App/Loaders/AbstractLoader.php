<?php

namespace Jalle19\Tlk\SongBook\App\Loaders;

use Doctrine\Common\Collections\Collection;
use Jalle19\Tlk\SongBook\Resources\ResourceManager;

/**
 * Class AbstractLoader
 * @package Jalle19\Tlk\SongBook\App\Loaders
 */
abstract class AbstractLoader
{
    /**
     * @var ResourceManager
     */
    protected $resourceManager;

    /**
     * @return Collection
     */
    abstract public function load(): Collection;

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
