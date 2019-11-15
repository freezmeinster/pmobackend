<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Exception;

class HttpForbiddenException extends HttpSpecializedException
{
    protected $code = 403;
    protected $message = 'Forbidden.';
    protected $title = '403 Forbidden';
    protected $description = 'You are not permitted to perform the requested operation.';
}
