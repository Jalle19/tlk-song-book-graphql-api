<?php

namespace Jalle19\Tlk\SongBook\GraphQL\Resolvers;

use Digia\GraphQL\Relay\ArrayConnectionBuilder;
use Digia\GraphQL\Relay\ConnectionArguments;
use Digia\GraphQL\Relay\ConnectionInterface;
use Digia\GraphQL\Schema\Resolver\AbstractResolver;
use Jalle19\Tlk\SongBook\App\Models\Category;
use Jalle19\Tlk\SongBook\App\Services\SongService;

/**
 * Class CategoryResolver
 * @package Jalle19\Tlk\SongBook\GraphQL\Resolvers
 */
class CategoryResolver extends AbstractResolver
{

    /**
     * @var SongService
     */
    private $songService;

    /**
     * CategoryResolver constructor.
     *
     * @param SongService $songService
     */
    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    /**
     * @param Category $rootValue
     * @param array    $args
     *
     * @return ConnectionInterface|null
     *
     * @throws \Digia\GraphQL\Relay\RelayException
     */
    public function resolveSongs(Category $rootValue, $args): ?ConnectionInterface
    {
        $songs     = $this->songService->findAllByCategoryId($rootValue->getId());
        $arguments = ConnectionArguments::fromArray($args);

        return ArrayConnectionBuilder::fromArray($songs, $arguments);
    }
}
