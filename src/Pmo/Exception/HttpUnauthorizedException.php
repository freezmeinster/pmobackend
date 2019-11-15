<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Exception;

class HttpUnauthorizedException extends HttpSpecializedException
{
    protected $code = 401;
    protected $message = 'Unauthorized.';
    protected $title = '401 Unauthorized';
    protected $description = 'The request requires valid user authentication.';
}
