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

    private const TEXT_SEARCH_MODE_ANY_PHRASE  = 'ANY_PHRASE';
    private const TEXT_SEARCH_MODE_ALL_PHRASES = 'ALL_PHRASES';

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

    /**
     * @param string $name
     *
     * @return array
     */
    public function findAllByName(string $name): array
    {
        return $this->songs->filter(function (Song $song) use ($name) {
            return $song->getName() === $name;
        })->toArray();
    }

    /**
     * @param string $text
     * @param string $mode
     *
     * @return array
     */
    public function findAllByText(string $text, string $mode): array
    {
        return $this->songs->filter(function (Song $song) use ($text, $mode) {
            $phrases = \explode(' ', $text);

            switch ($mode) {
                case self::TEXT_SEARCH_MODE_ANY_PHRASE:
                    foreach ($phrases as $phrase) {
                        if (\strpos($song->getText(), $phrase) !== false) {
                            return $song;
                        }
                    }
                    break;
                case self::TEXT_SEARCH_MODE_ALL_PHRASES:
                    $allPhrasesMatch = true;

                    foreach ($phrases as $phrase) {
                        if (\strpos($song->getText(), $phrase) === false) {
                            $allPhrasesMatch = false;
                        }
                    }

                    return $allPhrasesMatch;
                    break;
                default:
                    throw new \InvalidArgumentException('Unknown text search mode');
            }

            return $song->getName() === $text;
        })->toArray();
    }
}
