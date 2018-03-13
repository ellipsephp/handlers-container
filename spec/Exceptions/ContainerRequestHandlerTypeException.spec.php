<?php

use Ellipse\Handlers\Exceptions\ContainerRequestHandlerTypeException;

describe('ContainerRequestHandlerTypeException', function () {

    it('should extend TypeError', function () {

        $test = new ContainerRequestHandlerTypeException('alias', 'middleware');

        expect($test)->toBeAnInstanceOf(TypeError::class);

    });

});
