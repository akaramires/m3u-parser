<?php

declare(strict_types=1);

namespace Akaramires\M3uParser\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UndefinedTagStringException extends Exception
{
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct(
            message: $message,
            code: Response::HTTP_BAD_REQUEST,
            previous: $previous,
        );
    }
}
