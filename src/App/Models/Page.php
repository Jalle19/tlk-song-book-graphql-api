<?php

namespace Jalle19\Tlk\SongBook\App\Models;

/**
 * Class Page
 * @package Jalle19\Tlk\SongBook\App\Models
 */
class Page
{

    /**
     * @var int
     */
    private $number;

    /**
     * Page constructor.
     *
     * @param int $number
     */
    public function __construct(int $number)
    {
        $this->number = $number;
    }

    /**
     * Since everything that is used as a Node requires an "id", let's use the page number
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->number;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }
}
