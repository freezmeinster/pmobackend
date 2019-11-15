<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Pmo\Interfaces;

interface Psr17FactoryProviderInterface
{
    /**
     * @return string[]
     */
    public static function getFactories(): array;

    /**
     * @var string[]
     */
    public static function setFactories(array $factories): void;

    /**
     * @param string $factory
     * @return void
     */
    public static function addFactory(string $factory): void;
}
