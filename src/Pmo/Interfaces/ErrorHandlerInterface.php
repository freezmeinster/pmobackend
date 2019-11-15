<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Pmo\Interfaces;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

interface ErrorHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param Throwable              $exception
     * @param bool                   $displayErrorDetails
     * @param bool                   $logErrors
     * @param bool                   $logErrorDetails
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface;
}
