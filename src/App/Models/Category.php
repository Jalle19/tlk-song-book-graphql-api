<?php

namespace Jalle19\Tlk\SongBook\App\Models;

/**
 * Class Category
 * @package Jalle19\Tlk\SongBook\App\Models
 */
class Category
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * Category constructor.
     *
     * @param int    $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    /**
     * @param array $data
     *
     * @return Category
     */
    public static function createFromArray(array $data): Category
    {
        return new Category($data['id'], $data['name']);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
