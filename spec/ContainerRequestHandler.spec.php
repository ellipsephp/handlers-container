<?php

use function Eloquent\Phony\Kahlan\mock;

use Psr\Container\ContainerInterface;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Handlers\ContainerRequestHandler;
use Ellipse\Handlers\Exceptions\ContainerRequestHandlerTypeException;

describe('ContainerRequestHandler', function () {

    beforeEach(function () {

        $this->container = mock(ContainerInterface::class);

        $this->handler = new ContainerRequestHandler($this->container->get(), 'SomeRequestHandler');

    });

    it('should implement RequestHandlerInterface', function () {

        expect($this->handler)->toBeAnInstanceOf(RequestHandlerInterface::class);

    });

    describe('->handle()', function () {

        beforeEach(function () {

            $this->request = mock(ServerRequestInterface::class)->get();
            $this->response = mock(ResponseInterface::class)->get();

        });

        context('when the value retrieved from the container is an object implementing RequestHandlerInterface', function () {

            it('should proxy the request handler ->handle() method', function () {

                $handler = mock(RequestHandlerInterface::class);

                $this->container->get->with('SomeRequestHandler')->returns($handler);

                $handler->handle->with($this->request)->returns($this->response);

                $test = $this->handler->handle($this->request);

                expect($test)->toBe($this->response);

            });

        });

        context('when the value retrieved from the container is not an object implementing RequestHandlerInterface', function () {

            it('should throw a ContainerRequestHandlerTypeException', function () {

                $this->container->get->with('SomeRequestHandler')->returns('handler');

                $test = function () {

                    $this->handler->handle($this->request);

                };

                $exception = new ContainerRequestHandlerTypeException('SomeRequestHandler', 'handler');

                expect($test)->toThrow($exception);

            });

        });

    });

});
