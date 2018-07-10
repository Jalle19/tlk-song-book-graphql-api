<?php

namespace Jalle19\Tlk\SongBook\Tests\GraphQL\Resolvers;

use Jalle19\Tlk\SongBook\App\Models\Song;
use Jalle19\Tlk\SongBook\App\Services\CategoryService;
use Jalle19\Tlk\SongBook\App\Services\PageService;
use Jalle19\Tlk\SongBook\App\Services\SongService;
use Jalle19\Tlk\SongBook\GraphQL\Resolvers\QueryResolver;
use PHPUnit\Framework\TestCase;

/**
 * Class QueryResolverTest
 * @package Jalle19\Tlk\SongBook\Tests\GraphQL\Resolvers
 */
class QueryResolverTest extends TestCase
{

    /**
     * @throws \Digia\GraphQL\Relay\RelayException
     */
    public function testResolveSongs(): void
    {
        $songService = $this->getMockedSongService();

        $songService->expects($this->once())
                    ->method('findAll')
                    ->willReturn([$this->createSong(), $this->createSong(), $this->createSong()]);

        $queryResolver = new QueryResolver(
            $this->getMockedCategoryService(),
            $songService,
            $this->getMockedPageService()
        );

        $result = $queryResolver->resolveSongs(null, []);

        $this->assertCount(3, $result->getEdges());
    }

    /**
     * @throws \Digia\GraphQL\Relay\RelayException
     */
    public function testResolveSongsByName(): void
    {
        $songService = $this->getMockedSongService();

        $songService->expects($this->once())
                    ->method('findAllByName')
                    ->with('Song name')
                    ->willReturn([$this->createSong(), $this->createSong(), $this->createSong()]);

        $queryResolver = new QueryResolver(
            $this->getMockedCategoryService(),
            $songService,
            $this->getMockedPageService()
        );

        $result = $queryResolver->resolveSongs(null, [
            'search' => [
                'name' => 'Song name',
            ],
        ]);

        $this->assertCount(3, $result->getEdges());
    }

    /**
     * @throws \Digia\GraphQL\Relay\RelayException
     */
    public function testResolveSongsByText(): void
    {
        $songService = $this->getMockedSongService();

        $songService->expects($this->once())
                    ->method('findAllByText')
                    ->with('Song text', 'Mode')
                    ->willReturn([$this->createSong(), $this->createSong(), $this->createSong()]);

        $queryResolver = new QueryResolver(
            $this->getMockedCategoryService(),
            $songService,
            $this->getMockedPageService()
        );

        $result = $queryResolver->resolveSongs(null, [
            'search' => [
                'text'           => 'Song text',
                'textSearchMode' => 'Mode',
            ],
        ]);

        $this->assertCount(3, $result->getEdges());
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|SongService
     */
    private function getMockedSongService()
    {
        return $this->getMockBuilder(SongService::class)
                    ->setMethods(['findAll', 'findAllByName', 'findAllByText'])
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|CategoryService
     */
    private function getMockedCategoryService()
    {
        return $this->getMockBuilder(CategoryService::class)
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|PageService
     */
    private function getMockedPageService()
    {
        return $this->getMockBuilder(PageService::class)
                    ->disableOriginalConstructor()
                    ->getMock();
    }

    /**
     * @return Song
     */
    private function createSong(): Song
    {
        return new Song(1, 1, 1, 1, 'Song name', 'Song notes', 'Song text');
    }
}
