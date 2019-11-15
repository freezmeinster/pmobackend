<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Pmo\Interfaces;

interface AdvancedCallableResolverInterface extends CallableResolverInterface
{
    /**
     * Resolve $toResolve into a callable
     *
     * @param string|callable $toResolve
     *
     * @return callable
     */
    public function resolveRoute($toResolve): callable;

    /**
     * Resolve $toResolve into a callable
     *
     * @param string|callable $toResolve
     *
     * @return callable
     */
    public function resolveMiddleware($toResolve): callable;
}
