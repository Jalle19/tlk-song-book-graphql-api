<?php

namespace Jalle19\Tlk\SongBook\App\Services;

use Doctrine\Common\Collections\Collection;
use Jalle19\Tlk\SongBook\App\Exceptions\EntityNotFoundException;
use Jalle19\Tlk\SongBook\App\Loaders\SongLoader;
use Jalle19\Tlk\SongBook\App\Models\Song;

/**
 * Class SongService
 * @package Jalle19\Tlk\SongBook\App\Services
 */
class SongService
{

    /**
     * @var Collection
     */
    private $songs;

    /**
     * SongService constructor.
     *
     * @param SongLoader $songLoader
     */
    public function __construct(SongLoader $songLoader)
    {
        $this->songs = $songLoader->load();
    }

    /**
     * @param int $id
     *
     * @return Song|null
     */
    public function findOneById(int $id): ?Song
    {
        $songs = $this->songs->filter(function (Song $song) use ($id) {
            return $song->getId() === $id;
        });

        return !$songs->isEmpty() ? $songs->first() : null;
    }

    /**
     * @param int $id
     *
     * @return Song
     *
     * @throws EntityNotFoundException
     */
    public function tryFindOneById(int $id): Song
    {
        $song = $this->findOneById($id);

        if ($song === null) {
            throw new EntityNotFoundException('Song not found');
        }

        return $song;
    }

    /**
     * @param int $categoryId
     *
     * @return Song[]
     */
    public function findAllByCategoryId(int $categoryId): array
    {
        return $this->songs->filter(function (Song $song) use ($categoryId) {
            return $song->getCategoryId() === $categoryId;
        })->toArray();
    }

    /**
     * @param int $pageNumber
     *
     * @return array
     */
    public function findAllByPageNumber(int $pageNumber): array
    {
        return $this->songs->filter(function (Song $song) use ($pageNumber) {
            return $song->getPageNumber() === $pageNumber;
        })->toArray();
    }

    /**
     * @return Song[]
     */
    public function findAll(): array
    {
        return $this->songs->toArray();
    }
}
