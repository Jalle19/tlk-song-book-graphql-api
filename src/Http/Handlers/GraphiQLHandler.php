<?php

namespace Jalle19\Tlk\SongBook\Http\Handlers;

use Jalle19\Tlk\SongBook\Resources\ResourceManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class GraphiQLHandler
 * @package Jalle19\Tlk\SongBook\Http\Handlers
 */
class GraphiQLHandler implements RequestHandlerInterface
{

    /**
     * @var ResourceManager
     */
    private $resourceManager;

    /**
     * GraphiQLHandler constructor.
     *
     * @param ResourceManager $resourceManager
     */
    public function __construct(ResourceManager $resourceManager)
    {
        $this->resourceManager = $resourceManager;
    }

    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->resourceManager->getResourceAsString('views/graphiql.html'));
    }
}
