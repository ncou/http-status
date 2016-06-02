<?php
namespace Narrowspark\HttpStatus\Exception;

class NetworkAuthenticationRequiredException extends AbstractServerErrorException
{
    /**
     * @var string
     */
    protected $message = '511 Network Authentication Required';

    /**
     * @var int
     */
    protected $code = 511;
}