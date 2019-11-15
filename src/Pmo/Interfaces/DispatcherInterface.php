<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Pmo\Interfaces;

use Pmo\Routing\RoutingResults;

interface DispatcherInterface
{
    /**
     * Get routing results for a given request method and uri
     *
     * @param string $method
     * @param string $uri
     * @return RoutingResults
     */
    public function dispatch(string $method, string $uri): RoutingResults;

    /**
     * Get allowed methods for a given uri
     *
     * @param string $uri
     * @return array
     */
    public function getAllowedMethods(string $uri): array;
}
