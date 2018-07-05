<?php

namespace Jalle19\Tlk\SongBook\GraphQL\Resolvers;

use Digia\GraphQL\Relay\ArrayConnectionBuilder;
use Digia\GraphQL\Relay\ConnectionArguments;
use Digia\GraphQL\Relay\ConnectionInterface;
use Digia\GraphQL\Schema\Resolver\AbstractResolver;
use Jalle19\Tlk\SongBook\App\Models\Page;
use Jalle19\Tlk\SongBook\App\Services\SongService;

/**
 * Class PageResolver
 * @package Jalle19\Tlk\SongBook\GraphQL\Resolvers
 */
class PageResolver extends AbstractResolver
{

    /**
     * @var SongService
     */
    private $songService;

    /**
     * PageResolver constructor.
     *
     * @param SongService $songService
     */
    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    /**
     * @param Page  $rootValue
     * @param array $args
     *
     * @return ConnectionInterface
     *
     * @throws \Digia\GraphQL\Relay\RelayException
     */
    public function resolveSongs(Page $rootValue, array $args): ConnectionInterface
    {
        $songs     = $this->songService->findAllByPageNumber($rootValue->getNumber());
        $arguments = ConnectionArguments::fromArray($args);

        return ArrayConnectionBuilder::fromArray($songs, $arguments);
    }
}
