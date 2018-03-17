<?php declare(strict_types=1);

namespace Ellipse\Handlers;

use Psr\Container\ContainerInterface;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Handlers\Exceptions\ContainedRequestHandlerTypeException;

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
    private $handler;

    /**
     * Set up a container request handler with the given container and container
     * id.
     *
     * @param \Psr\Container\ContainerInterface $container
     * @param string                            $handler
     */
    public function __construct(ContainerInterface $container, string $handler)
    {
        $this->container = $container;
        $this->handler = $handler;
    }

    /**
     * Get a request handler from the container then proxy its ->handle()
     * method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Ellipse\Handlers\Exceptions\ContainedRequestHandlerTypeException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $handler = $this->container->get($this->handler);

        if ($handler instanceof RequestHandlerInterface) {

            return $handler->handle($request);

        }

        throw new ContainedRequestHandlerTypeException($this->handler, $handler);
    }
}
