<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Interfaces;

use Psr\Http\Message\ServerRequestInterface;

interface ServerRequestCreatorInterface
{
    /**
     * @return ServerRequestInterface
     */
    public function createServerRequestFromGlobals(): ServerRequestInterface;
}
