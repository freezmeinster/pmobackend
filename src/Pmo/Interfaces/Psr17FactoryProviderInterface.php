<?php
/**
 * Pmo Framework (https://)
 *
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
