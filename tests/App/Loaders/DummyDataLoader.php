<?php

namespace Jalle19\Tlk\SongBook\Tests\App\Loaders;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Jalle19\Tlk\SongBook\App\Loaders\LoaderInterface;

/**
 * Class DummyDataLoader
 * @package Jalle19\Tlk\SongBook\Tests\App\Loaders
 */
class DummyDataLoader implements LoaderInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * DummyDataLoader constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @inheritdoc
     */
    public function load(): Collection
    {
        return new ArrayCollection($this->data);
    }
}
