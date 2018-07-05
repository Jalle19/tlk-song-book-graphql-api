<?php

namespace Jalle19\Tlk\SongBook\App\Loaders;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Jalle19\Tlk\SongBook\App\Models\Category;

/**
 * Class CategoryLoader
 * @package Jalle19\Tlk\SongBook\App\Loaders
 */
class CategoryLoader extends AbstractLoader
{

    /**
     * @return Collection
     */
    public function load(): Collection
    {
        return new ArrayCollection(array_map(function (array $data) {
            return Category::createFromArray($data);
        }, $this->resourceManager->getResourceAsArray('data/categories.php')));
    }
}
