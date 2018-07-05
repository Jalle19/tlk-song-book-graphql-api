<?php

namespace Jalle19\Tlk\SongBook\Http\Handlers;

use Digia\GraphQL\Schema\Schema;
use Jalle19\Tlk\SongBook\GraphQL\Resolvers\CategoryResolver;
use Jalle19\Tlk\SongBook\GraphQL\Resolvers\PageResolver;
use Jalle19\Tlk\SongBook\GraphQL\Resolvers\QueryResolver;
use Jalle19\Tlk\SongBook\GraphQL\Resolvers\SongResolver;
use Jalle19\Tlk\SongBook\Resources\ResourceManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use function Digia\GraphQL\buildSchema;
use function Digia\GraphQL\graphql;

/**
 * Class GraphQLHandler
 * @package Jalle19\Tlk\SongBook\Http\Handlers
 */
class GraphQLHandler implements RequestHandlerInterface
{

    /**
     * @var Schema
     */
    private $schema;

    /**
     * GraphQlHandler constructor.
     *
     * @param ResourceManager  $resourceManager
     * @param QueryResolver    $queryResolver
     * @param CategoryResolver $categoryResolver
     * @param SongResolver     $songResolver
     * @param PageResolver     $pageResolver
     *
     * @throws \Digia\GraphQL\Error\InvariantException
     */
    public function __construct(
        ResourceManager $resourceManager,
        QueryResolver $queryResolver,
        CategoryResolver $categoryResolver,
        SongResolver $songResolver,
        PageResolver $pageResolver
    ) {
        $source = $resourceManager->getResourceAsString('graphql/songBook.graphqls');

        $this->schema = buildSchema($source, [
            'Query'    => $queryResolver,
            'Category' => $categoryResolver,
            'Song'     => $songResolver,
            'Page'     => $pageResolver,
        ]);
    }

    /**
     * @inheritdoc
     *
     * @throws \Digia\GraphQL\Error\InvariantException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $result = graphql($this->schema, $this->getQuery($request));

        return new JsonResponse($result);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    private function getQuery(ServerRequestInterface $request): string
    {
        $body = \json_decode($request->getBody()->getContents());

        if (\json_last_error() !== JSON_ERROR_NONE || !isset($body->query)) {
            throw new \InvalidArgumentException('Invalid JSON in request body');
        }

        return $body->query;
    }
}
