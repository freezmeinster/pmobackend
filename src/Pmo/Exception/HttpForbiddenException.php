<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
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
