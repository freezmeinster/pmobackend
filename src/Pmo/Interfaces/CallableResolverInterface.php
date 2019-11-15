<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Pmo\Interfaces;

interface CallableResolverInterface
{
    /**
     * Resolve $toResolve into a callable
     *
     * @param string|callable $toResolve
     * @return callable
     */
    public function resolve($toResolve): callable;
}
