<?php declare(strict_types=1);

namespace Ellipse\Handlers\Exceptions;

use TypeError;

use Psr\Http\Server\RequestHandlerInterface;

class ContainerRequestHandlerTypeException extends TypeError
{
    public function __construct(string $alias, $value)
    {
        $template = "The value contained in the '%s' entry of the container is of type %s - object implementing %s expected";

        $type = is_object($value) ? get_class($value) : gettype($value);

        $msg = sprintf($template, $alias, $type, RequestHandlerInterface::class);

        parent::__construct($msg);
    }
}
