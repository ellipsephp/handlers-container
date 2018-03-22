# Request handler container

This package provides a [Psr-15](https://www.php-fig.org/psr/psr-15/) request handler proxying a [Psr-11](https://www.php-fig.org/psr/psr-11/) container entry.

**Require** php >= 7.0

**Installation** `composer require ellipse/handlers-container`

**Run tests** `./vendor/bin/kahlan`

- [Using container entries as request handlers](#using-container-entries-as-request-handlers)
- [Example using auto wiring](#example-using-auto-wiring)

## Using container entries as request handlers

The class `Ellipse\Handlers\ContainerRequestHandler` takes an implementation of `Psr\Container\ContainerInterface` and a container id as parameters. Its `->handle()` method retrieve a request handler from the container using this id and proxy its `->handle()` method.

It can be useful in situations the container entry should be resolved at the time the request is handled.

An `Ellipse\Handlers\Exceptions\ContainedRequestHandlerTypeException` is thrown when the value retrieved from the container is not an object implementing `Psr\Http\Server\RequestHandlerInterface`.

```php
<?php

namespace App;

use SomePsr11Container;

use Ellipse\Handlers\ContainerRequestHandler;

// Get some Psr-11 container.
$container = new SomePsr11Container;

// Add a request handler in the container.
$container->set('some.request.handler', function () {

    return new SomeRequestHandler;

});

// Create a container request handler with the Psr-11 container and the entry id.
$handler = new ContainerRequestHandler($container, 'some.request.handler');

// The handler ->handle() method retrieve the request handler from the container and proxy it.
$response = $handler->handle($request);
```

## Example using auto wiring

It can be cumbersome to register every request handler classes in the container. Here is how to auto wire request handler instances using the `Ellipse\Container\ReflectionContainer` class from the [ellipse/container-reflection](https://github.com/ellipsephp/container-reflection) package.

```php
<?php

namespace App;

use Psr\Http\Server\RequestHandlerInterface;

use SomePsr11Container;

use Ellipse\Container\ReflectionContainer;
use Ellipse\Handlers\ContainerRequestHandler;

// Get some Psr-11 container.
$container = new SomePsr11Container;

// Decorate the container with a reflection container.
// Specify the request handler implementations can be auto wired.
$reflection = new ReflectionContainer($container, [
    RequestHandlerInterface::class,
]);

// Create a container request handler with the reflection container and a request handler class name.
$handler = new ContainerRequestHandler($reflection, SomeRequestHandler::class);

// An instance of SomeRequestHandler is built and its ->handle() method is proxied.
$response = $handler->handle($request);
```
