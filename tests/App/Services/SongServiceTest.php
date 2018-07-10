<?php

namespace Jalle19\Tlk\SongBook\Tests\App\Services;

use Jalle19\Tlk\SongBook\App\Models\Song;
use Jalle19\Tlk\SongBook\App\Services\SongService;
use Jalle19\Tlk\SongBook\Tests\App\Loaders\DummyDataLoader;
use PHPUnit\Framework\TestCase;

/**
 * Class SongServiceTest
 * @package Jalle19\Tlk\SongBook\Tests\App\Services
 */
class SongServiceTest extends TestCase
{

    /**
     * @var SongService
     */
    private $songService;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->songService = new SongService(new DummyDataLoader([
            new Song(1, 1, 1, 1, 'Vårt land', null, 'Vårt land vårt land, vårt fosterland'),
            new Song(2, 1, 1, 1, 'Modersmålets sång', null, 'Hur härligt sången klingar'),
            new Song(3, 1, 1, 1, 'Should not match anything', null, ''),
        ]));
    }

    public function testFindAllByName(): void
    {
        $this->assertEmpty($this->songService->findAllByName('no match'));
        $this->assertCount(1, $this->songService->findAllByName('Vårt land'));
    }

    public function testFindAllByText(): void
    {
        // No matches whatsoever
        $this->assertEmpty($this->songService->findAllByText('this text does not exist',
            SongService::TEXT_SEARCH_MODE_ALL_PHRASES));
        $this->assertEmpty($this->songService->findAllByText('this text does not exist',
            SongService::TEXT_SEARCH_MODE_ANY_PHRASE));

        // Matches on ANY_PHRASE, not on ALL_PHRASES
        $this->assertEmpty($this->songService->findAllByText('vårt land morjens',
            SongService::TEXT_SEARCH_MODE_ALL_PHRASES));
        $result = $this->songService->findAllByText('vårt land', SongService::TEXT_SEARCH_MODE_ANY_PHRASE);

        $this->assertCount(1, $result);
        $this->assertEquals(1, $result[0]->getId());

        // Matches on ALL_PHRASES
        $result = $this->songService->findAllByText('Hur härligt sången klingar',
            SongService::TEXT_SEARCH_MODE_ALL_PHRASES);

        $this->assertCount(1, $result);
        /** @var Song $firstResult */
        $firstResult = reset($result);

        $this->assertEquals(2, $firstResult->getId());
    }
}
