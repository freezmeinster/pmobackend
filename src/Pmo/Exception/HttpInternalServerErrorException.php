<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Exception;

class HttpInternalServerErrorException extends HttpSpecializedException
{
    protected $code = 500;
    protected $message = 'Internal server error.';
    protected $title = '500 Internal Server Error';
    protected $description = 'Unexpected condition encountered preventing server from fulfilling request.';
}
