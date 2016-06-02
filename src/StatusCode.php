<?php
namespace Narrowspark\HttpStatus;

use InvalidArgumentException;
use OutOfBoundsException;
use Narrowspark\HttpStatus\Exception;

class StatusCode
{
    /**
     * Allowed range for a valid HTTP status code
     */
    const MINIMUM = 100;
    const MAXIMUM = 599;

    /**
     * Array of standard HTTP status code/reason phrases.
     *
     * @var array
     */
    private $phrases = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-status',
        208 => 'Already Reported',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    ];

    /**
     * Array of standard HTTP status code/reason exceptions.
     *
     * @var array
     */
    private $phrasesExceptions = [
        400 => Exception\BadRequestException::class,
        401 => Exception\UnauthorizedException::class,
        402 => Exception\PaymentRequiredException::class,
        403 => Exception\ForbiddenException::class,
        404 => Exception\NotFoundException::class,
        405 => Exception\MethodNotAllowedException::class,
        406 => Exception\NotAcceptableException::class,
        407 => Exception\ProxyAuthenticationRequiredException::class,
        408 => Exception\RequestTimeoutException::class,
        409 => Exception\ConflictException::class,
        410 => Exception\GoneException::class,
        411 => Exception\LengthRequiredException::class,
        412 => Exception\PreconditionFailedException::class,
        413 => Exception\RequestEntityTooLargeException::class,
        414 => Exception\RequestUriTooLongException::class,
        415 => Exception\UnsupportedMediaTypeException::class,
        416 => Exception\RequestedRangeNotSatisfiableException::class,
        417 => Exception\ExpectationFailedException::class,
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => Exception\InternalServerErrorException::class,
        501 => Exception\NotImplementedException::class,
        502 => Exception\BadGatewayException::class,
        503 => Exception\ServiceUnavailableException::class,
        504 => Exception\GatewayTimeoutException::class,
        505 => Exception\HttpVersionNotSupportedException::class,
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        511 => 'Network Authentication Required',
    ];

    /**
     * Create a new StatusCode Instance.
     *
     * @param array $status a array of HTTP status code and
     *                      their associated reason phrase.
     *
     * @throws InvalidArgumentException if the collection is not valid
     */
    public function __construct(array $status = [])
    {

    }

    /**
     * Get the text for a given status code.
     *
     * @param int $code http status code
     *
     * @throws InvalidArgumentException If the requested $code is not valid
     * @throws OutOfBoundsException     If the requested $code is not found
     *
     * @return string Returns text for the given status code
     */
    public function getReasonPhrase($code)
    {
        $code = $this->filterStatusCode($code);

        if (! isset($this->phrases[$code])) {
            throw new OutOfBoundsException(sprintf('Unknown http status code: `%s`', $code));
        }

        return $this->phrases[$code];
    }

    /**
     * Get the text for a given status code
     *
     * @param int $code http status code
     *
     * @throws InvalidArgumentException
     */
    public function getReasonPhraseException($code)
    {
        $code = $this->filterStatusCode($code);

        if (! isset($this->phrases[$code])) {
            throw new OutOfBoundsException(sprintf('Unknown http status code: `%s`', $code));
        }

        if (isset($this->phrasesExceptions[$code])) {
            throw new static::$phrasesExceptions[$code];
        }
    }

    /**
     * Filter a HTTP Status code
     *
     * @param int $code
     *
     * @throws InvalidArgumentException if the HTTP status code is invalid
     *
     * @return int
     */
    protected function filterStatusCode($code)
    {
        $code = filter_var($code, FILTER_VALIDATE_INT, ['options' => [
            'min_range' => self::MINIMUM,
            'max_range' => self::MAXIMUM,
        ]]);

        if (! $code) {
            throw new InvalidArgumentException(
                'The submitted code must be a positive integer between ' . self::MINIMUM . ' and ' . self::MAXIMUM
            );
        }

        return $code;
    }
}
