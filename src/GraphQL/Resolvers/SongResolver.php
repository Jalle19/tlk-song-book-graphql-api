<?php

namespace Jalle19\Tlk\SongBook\GraphQL\Resolvers;

use Digia\GraphQL\Schema\Resolver\AbstractResolver;
use Jalle19\Tlk\SongBook\App\Models\Category;
use Jalle19\Tlk\SongBook\App\Models\Song;
use Jalle19\Tlk\SongBook\App\Services\CategoryService;

/**
 * Class SongResolver
 * @package Jalle19\Tlk\SongBook\GraphQL\Resolvers
 */
class SongResolver extends AbstractResolver
{

    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * SongResolver constructor.
     *
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @param Song  $rootValue
     * @param array $args
     *
     * @return Category
     *
     * @throws \Jalle19\Tlk\SongBook\App\Exceptions\EntityNotFoundException
     */
    public function resolveCategory(Song $rootValue, array $args): Category
    {
        return $this->categoryService->tryFindOneById($rootValue->getCategoryId());
    }
}
