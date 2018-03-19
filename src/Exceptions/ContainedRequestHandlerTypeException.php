<?php declare(strict_types=1);

namespace Ellipse\Handlers\Exceptions;

use TypeError;

use Psr\Http\Server\RequestHandlerInterface;

use Ellipse\Exceptions\ContainerEntryTypeErrorMessage;

class ContainedRequestHandlerTypeException extends TypeError implements ContainerRequestHandlerExceptionInterface
{
    public function __construct(string $id, $value)
    {
        $msg = new ContainerEntryTypeErrorMessage($id, $value, RequestHandlerInterface::class);

        parent::__construct((string) $msg);
    }
}
