<?php

namespace Jalle19\Tlk\SongBook\App\Loaders;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Jalle19\Tlk\SongBook\App\Models\Song;

/**
 * Class SongLoader
 * @package Jalle19\Tlk\SongBook\App\Loaders
 */
class SongLoader extends AbstractLoader
{

    /**
     * @return Collection
     */
    public function load(): Collection
    {
        return new ArrayCollection(\array_map(function (array $data) {
            return Song::createFromArray($data);
        }, $this->resourceManager->getResourceAsArray('data/songs.php')));
    }
}
