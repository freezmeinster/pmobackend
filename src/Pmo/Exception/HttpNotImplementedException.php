<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Exception;

class HttpNotImplementedException extends HttpSpecializedException
{
    protected $code = 501;
    protected $message = 'Not implemented.';
    protected $title = '501 Not Implemented';
    protected $description = 'The server does not support the functionality required to fulfill the request.';
}
