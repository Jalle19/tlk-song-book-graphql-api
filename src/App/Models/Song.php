<?php

namespace Jalle19\Tlk\SongBook\App\Models;

/**
 * Class Song
 * @package Jalle19\Tlk\SongBook\App\Models
 */
class Song
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var int|null
     */
    private $number;

    /**
     * @var int|null
     */
    private $pageNumber;

    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $notes;

    /**
     * @var string
     */
    private $text;

    /**
     * Song constructor.
     *
     * @param int         $id
     * @param int|null    $number
     * @param int|null    $pageNumber
     * @param int         $categoryId
     * @param string      $name
     * @param null|string $notes
     * @param string      $text
     */
    public function __construct(
        int $id,
        ?int $number,
        ?int $pageNumber,
        int $categoryId,
        string $name,
        ?string $notes,
        string $text
    ) {
        $this->id         = $id;
        $this->number     = $number;
        $this->pageNumber = $pageNumber;
        $this->categoryId = $categoryId;
        $this->name       = $name;
        $this->notes      = !empty($notes) ? $notes : null;
        $this->text       = $text;
    }

    /**
     * @param array $data
     *
     * @return Song
     */
    public static function createFromArray(array $data): Song
    {
        return new Song(
            $data['id'],
            $data['song_no'],
            $data['page_no'],
            $data['category_id'],
            $data['name'],
            $data['notes'],
            $data['text']
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @return int|null
     */
    public function getPageNumber(): ?int
    {
        return $this->pageNumber;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
