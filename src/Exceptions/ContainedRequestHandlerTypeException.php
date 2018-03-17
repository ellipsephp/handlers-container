<?php declare(strict_types=1);

namespace Ellipse\Handlers\Exceptions;

use TypeError;

use Psr\Http\Server\RequestHandlerInterface;

class ContainedRequestHandlerTypeException extends TypeError implements ContainerRequestHandlerExceptionInterface
{
    public function __construct(string $id, $value)
    {
        $template = "The value contained in the '%s' entry of the container is of type %s - object implementing %s expected";

        $type = is_object($value) ? get_class($value) : gettype($value);

        $msg = sprintf($template, $id, $type, RequestHandlerInterface::class);

        parent::__construct($msg);
    }
}
