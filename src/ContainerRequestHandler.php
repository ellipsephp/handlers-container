<?php declare(strict_types=1);

namespace Ellipse\Handlers;

use Psr\Container\ContainerInterface;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Handlers\Exceptions\ContainerRequestHandlerTypeException;

class ContainerRequestHandler implements RequestHandlerInterface
{
    /**
     * The container.
     *
     * @var \Psr\Container\ContainerInterface
     */
    private $container;

    /**
     * The container id to use to retrieve the request handler.
     *
     * @var string
     */
    private $id;

    /**
     * Set up a container request handler with the given container and id.
     *
     * @param \Psr\Container\ContainerInterface $container
     * @param string                            $id
     */
    public function __construct(ContainerInterface $container, string $id)
    {
        $this->container = $container;
        $this->id = $id;
    }

    /**
     * Get a request handler from the container then proxy its ->handle()
     * method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Ellipse\Handlers\Exceptions\ContainerRequestHandlerTypeException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $handler = $this->container->get($this->id);

        if ($handler instanceof RequestHandlerInterface) {

            return $handler->handle($request);

        }

        throw new ContainerRequestHandlerTypeException($this->id, $handler);
    }
}
