<?php

namespace Jalle19\Tlk\SongBook\App\Loaders;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Jalle19\Tlk\SongBook\App\Models\Page;

/**
 * Class PageLoader
 * @package Jalle19\Tlk\SongBook\App\Loaders
 */
class PageLoader extends AbstractLoader
{
    /**
     * @return Collection
     */
    public function load(): Collection
    {
        // Filter out songs without page numbers
        $songsWithPageNumbers = array_filter($this->resourceManager->getResourceAsArray('data/songs.php'),
            function (array $data) {
                return $data['page_no'] !== null;
            });

        $pageNumbers = array_unique(array_map(function (array $data) {
            return $data['page_no'];
        }, $songsWithPageNumbers));

        return new ArrayCollection(array_map(function (int $pageNumber) {
            return new Page($pageNumber);
        }, $pageNumbers));
    }
}
