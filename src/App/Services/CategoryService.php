<?php

namespace Jalle19\Tlk\SongBook\App\Services;

use Doctrine\Common\Collections\Collection;
use Jalle19\Tlk\SongBook\App\Exceptions\EntityNotFoundException;
use Jalle19\Tlk\SongBook\App\Loaders\LoaderInterface;
use Jalle19\Tlk\SongBook\App\Models\Category;

/**
 * Class CategoryService
 * @package Jalle19\Tlk\SongBook\App\Services
 */
class CategoryService
{

    /**
     * @var Collection
     */
    private $categories;

    /**
     * CategoryService constructor.
     *
     * @param LoaderInterface $categoryLoader
     */
    public function __construct(LoaderInterface $categoryLoader)
    {
        $this->categories = $categoryLoader->load();
    }

    /**
     * @param int $id
     *
     * @return Category|null
     */
    public function findOneById(int $id): ?Category
    {
        $categories = $this->categories->filter(function (Category $category) use ($id) {
            return $category->getId() === $id;
        });

        return !$categories->isEmpty() ? $categories->first() : null;
    }

    /**
     * @param int $id
     *
     * @return Category
     *
     * @throws EntityNotFoundException
     */
    public function tryFindOneById(int $id): Category
    {
        $category = $this->findOneById($id);

        if ($category === null) {
            throw new EntityNotFoundException('Category not found');
        }

        return $category;
    }

    /**
     * @return Category[]
     */
    public function findAll(): array
    {
        return $this->categories->toArray();
    }
}
