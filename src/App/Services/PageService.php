<?php

namespace Jalle19\Tlk\SongBook\App\Services;

use Doctrine\Common\Collections\Collection;
use Jalle19\Tlk\SongBook\App\Exceptions\EntityNotFoundException;
use Jalle19\Tlk\SongBook\App\Loaders\PageLoader;
use Jalle19\Tlk\SongBook\App\Models\Page;

/**
 * Class PageService
 * @package Jalle19\Tlk\SongBook\App\Services
 */
class PageService
{

    /**
     * @var Collection
     */
    private $pages;

    /**
     * PageService constructor.
     *
     * @param PageLoader $pageLoader
     */
    public function __construct(PageLoader $pageLoader)
    {
        $this->pages = $pageLoader->load();
    }

    /**
     * @param int $number
     *
     * @return Page|null
     */
    public function findOneByNumber(int $number): ?Page
    {
        $pages = $this->pages->filter(function (Page $page) use ($number) {
            return $page->getNumber() === $number;
        });

        return !$pages->isEmpty() ? $pages->first() : null;
    }

    /**
     * @param int $number
     *
     * @return Page
     *
     * @throws EntityNotFoundException
     */
    public function tryFindOneByNumber(int $number): Page
    {
        $page = $this->findOneByNumber($number);

        if ($page === null) {
            throw new EntityNotFoundException('Page not found');
        }

        return $page;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->pages->toArray();
    }
}
