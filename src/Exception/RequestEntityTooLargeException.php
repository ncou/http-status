<?php
namespace Narrowspark\HttpStatus\Exception;

class RequestEntityTooLargeException extends AbstractClientErrorException
{
    /**
     * @var string
     */
    protected $message = '413 Request Entity Too Large';

    /**
     * @var int
     */
    protected $code = 413;
}
