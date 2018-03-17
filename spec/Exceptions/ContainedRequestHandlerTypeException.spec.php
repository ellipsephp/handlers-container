<?php

use Ellipse\Handlers\Exceptions\ContainedRequestHandlerTypeException;
use Ellipse\Handlers\Exceptions\ContainerRequestHandlerExceptionInterface;

describe('ContainedRequestHandlerTypeException', function () {

    beforeEach(function () {

        $this->exception = new ContainedRequestHandlerTypeException('id', 'handler');

    });

    it('should implement ContainerRequestHandlerExceptionInterface', function () {

        expect($this->exception)->toBeAnInstanceOf(ContainerRequestHandlerExceptionInterface::class);

    });


    it('should extend TypeError', function () {

        expect($this->exception)->toBeAnInstanceOf(TypeError::class);

    });

});
