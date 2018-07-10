<?php

namespace Jalle19\Tlk\SongBook\App\Loaders;

use Doctrine\Common\Collections\Collection;

/**
 * Interface LoaderInterface
 * @package Jalle19\Tlk\SongBook\App\Loaders
 */
interface LoaderInterface
{

    /**
     * @return Collection
     */
    public function load(): Collection;
}
