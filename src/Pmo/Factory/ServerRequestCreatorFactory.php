<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Pmo\Factory;

use RuntimeException;
use Pmo\Factory\Psr17\Psr17Factory;
use Pmo\Factory\Psr17\Psr17FactoryProvider;
use Pmo\Factory\Psr17\PmoHttpServerRequestCreator;
use Pmo\Interfaces\Psr17FactoryProviderInterface;
use Pmo\Interfaces\ServerRequestCreatorInterface;

class ServerRequestCreatorFactory
{
    /**
     * @var Psr17FactoryProviderInterface|null
     */
    protected static $psr17FactoryProvider;

    /**
     * @var ServerRequestCreatorInterface|null
     */
    protected static $serverRequestCreator;

    /**
     * @var bool
     */
    protected static $slimHttpDecoratorsAutomaticDetectionEnabled = true;

    /**
     * @return ServerRequestCreatorInterface
     */
    public static function create(): ServerRequestCreatorInterface
    {
        return static::determineServerRequestCreator();
    }

    /**
     * @return ServerRequestCreatorInterface
     * @throws RuntimeException
     */
    public static function determineServerRequestCreator(): ServerRequestCreatorInterface
    {
        if (static::$serverRequestCreator) {
            return static::attemptServerRequestCreatorDecoration(static::$serverRequestCreator);
        }

        $psr17FactoryProvider = static::$psr17FactoryProvider ?? new Psr17FactoryProvider();

        /** @var Psr17Factory $psr17Factory */
        foreach ($psr17FactoryProvider->getFactories() as $psr17Factory) {
            if ($psr17Factory::isServerRequestCreatorAvailable()) {
                $serverRequestCreator = $psr17Factory::getServerRequestCreator();
                return static::attemptServerRequestCreatorDecoration($serverRequestCreator);
            }
        }

        throw new RuntimeException(
            "Could not detect any ServerRequest creator implementations. " .
            "Please install a supported implementation in order to use `App::run()` " .
            "without having to pass in a `ServerRequest` object. " .
            "See https://github.com/slimphp/Pmo/blob/4.x/README.md for a list of supported implementations."
        );
    }

    /**
     * @param ServerRequestCreatorInterface $serverRequestCreator
     * @return ServerRequestCreatorInterface
     */
    protected static function attemptServerRequestCreatorDecoration(
        ServerRequestCreatorInterface $serverRequestCreator
    ): ServerRequestCreatorInterface {
        if (static::$slimHttpDecoratorsAutomaticDetectionEnabled
            && PmoHttpServerRequestCreator::isServerRequestDecoratorAvailable()
        ) {
            return new PmoHttpServerRequestCreator($serverRequestCreator);
        }

        return $serverRequestCreator;
    }

    /**
     * @param Psr17FactoryProviderInterface $psr17FactoryProvider
     */
    public static function setPsr17FactoryProvider(Psr17FactoryProviderInterface $psr17FactoryProvider): void
    {
        static::$psr17FactoryProvider = $psr17FactoryProvider;
    }

    /**
     * @param ServerRequestCreatorInterface $serverRequestCreator
     */
    public static function setServerRequestCreator(ServerRequestCreatorInterface $serverRequestCreator): void
    {
        self::$serverRequestCreator = $serverRequestCreator;
    }

    /**
     * @param bool $enabled
     */
    public static function setPmoHttpDecoratorsAutomaticDetection(bool $enabled): void
    {
        static::$slimHttpDecoratorsAutomaticDetectionEnabled = $enabled;
    }
}
