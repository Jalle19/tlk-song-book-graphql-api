<?php

namespace Jalle19\Tlk\SongBook\GraphQL\Resolvers;

use Digia\GraphQL\Relay\ArrayConnectionBuilder;
use Digia\GraphQL\Relay\ConnectionArguments;
use Digia\GraphQL\Relay\ConnectionInterface;
use Digia\GraphQL\Schema\Resolver\AbstractResolver;
use Jalle19\Tlk\SongBook\App\Models\Category;
use Jalle19\Tlk\SongBook\App\Models\Page;
use Jalle19\Tlk\SongBook\App\Models\Song;
use Jalle19\Tlk\SongBook\App\Services\CategoryService;
use Jalle19\Tlk\SongBook\App\Services\PageService;
use Jalle19\Tlk\SongBook\App\Services\SongService;

/**
 * Class QueryResolver
 * @package Jalle19\Tlk\SongBook\GraphQL\Resolvers
 */
class QueryResolver extends AbstractResolver
{

    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @var SongService
     */
    private $songService;

    /**
     * @var PageService
     */
    private $pageService;

    /**
     * QueryResolver constructor.
     *
     * @param CategoryService $categoryService
     * @param SongService     $songService
     * @param PageService     $pageService
     */
    public function __construct(CategoryService $categoryService, SongService $songService, PageService $pageService)
    {
        $this->categoryService = $categoryService;
        $this->songService     = $songService;
        $this->pageService     = $pageService;
    }

    /**
     * @param null  $rootValue
     * @param array $args
     *
     * @return Category
     *
     * @throws \Jalle19\Tlk\SongBook\App\Exceptions\EntityNotFoundException
     */
    public function resolveCategory($rootValue, array $args): Category
    {
        return $this->categoryService->tryFindOneById($args['id']);
    }

    /**
     * @param null  $rootValue
     * @param array $args
     *
     * @return ConnectionInterface
     *
     * @throws \Digia\GraphQL\Relay\RelayException
     */
    public function resolveCategories($rootValue, array $args): ConnectionInterface
    {
        $categories = $this->categoryService->findAll();
        $arguments  = ConnectionArguments::fromArray($args);

        return ArrayConnectionBuilder::fromArray($categories, $arguments);
    }

    /**
     * @param null  $rootValue
     * @param array $args
     *
     * @return Page
     *
     * @throws \Jalle19\Tlk\SongBook\App\Exceptions\EntityNotFoundException
     */
    public function resolvePage($rootValue, array $args): Page
    {
        return $this->pageService->tryFindOneByNumber($args['number']);
    }

    /**
     * @param null  $rootValue
     * @param array $args
     *
     * @return ConnectionInterface
     *
     * @throws \Digia\GraphQL\Relay\RelayException
     */
    public function resolvePages($rootValue, array $args): ConnectionInterface
    {
        $pages     = $this->pageService->findAll();
        $arguments = ConnectionArguments::fromArray($args);

        return ArrayConnectionBuilder::fromArray($pages, $arguments);
    }

    /**
     * @param null  $rootValue
     * @param array $args
     *
     * @return Song
     *
     * @throws \Jalle19\Tlk\SongBook\App\Exceptions\EntityNotFoundException
     */
    public function resolveSong($rootValue, array $args): Song
    {
        return $this->songService->tryFindOneById($args['id']);
    }

    /**
     * @param null  $rootValue
     * @param array $args
     *
     * @return ConnectionInterface
     *
     * @throws \Digia\GraphQL\Relay\RelayException
     */
    public function resolveSongs($rootValue, array $args): ConnectionInterface
    {
        $songs     = $this->songService->findAll();
        $arguments = ConnectionArguments::fromArray($args);

        return ArrayConnectionBuilder::fromArray($songs, $arguments);
    }
}
