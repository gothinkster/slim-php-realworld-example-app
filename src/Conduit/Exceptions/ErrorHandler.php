<?php

namespace Conduit\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\Error;
use Slim\Handlers\NotFound;

class ErrorHandler extends Error
{

    /** @inheritdoc */
    public function __construct(bool $displayErrorDetails)
    {
        parent::__construct($displayErrorDetails);
    }

    /** @inheritdoc */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return (new NotFound())($request, $response);
        }

        return parent::__invoke($request, $response, $exception);
    }
}