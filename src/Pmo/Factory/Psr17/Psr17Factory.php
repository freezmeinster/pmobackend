<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Factory\Psr17;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use RuntimeException;
use Pmo\Interfaces\Psr17FactoryInterface;
use Pmo\Interfaces\ServerRequestCreatorInterface;

abstract class Psr17Factory implements Psr17FactoryInterface
{
    /**
     * @var string
     */
    protected static $responseFactoryClass;

    /**
     * @var string
     */
    protected static $streamFactoryClass;

    /**
     * @var string
     */
    protected static $serverRequestCreatorClass;

    /**
     * @var string
     */
    protected static $serverRequestCreatorMethod;

    /**
     * {@inheritdoc}
     */
    public static function getResponseFactory(): ResponseFactoryInterface
    {
        if (!static::isResponseFactoryAvailable()) {
            throw new RuntimeException(get_called_class() . ' could not instantiate a response factory.');
        }

        return new static::$responseFactoryClass;
    }

    /**
     * {@inheritdoc}
     */
    public static function getStreamFactory(): StreamFactoryInterface
    {
        if (!static::isStreamFactoryAvailable()) {
            throw new RuntimeException(get_called_class() . ' could not instantiate a stream factory.');
        }

        return new static::$streamFactoryClass;
    }

    /**
     * {@inheritdoc}
     */
    public static function getServerRequestCreator(): ServerRequestCreatorInterface
    {
        if (!static::isServerRequestCreatorAvailable()) {
            throw new RuntimeException(get_called_class() . ' could not instantiate a server request creator.');
        }

        return new ServerRequestCreator(static::$serverRequestCreatorClass, static::$serverRequestCreatorMethod);
    }

    /**
     * {@inheritdoc}
     */
    public static function isResponseFactoryAvailable(): bool
    {
        return static::$responseFactoryClass && class_exists(static::$responseFactoryClass);
    }

    /**
     * {@inheritdoc}
     */
    public static function isStreamFactoryAvailable(): bool
    {
        return static::$streamFactoryClass && class_exists(static::$streamFactoryClass);
    }

    /**
     * {@inheritdoc}
     */
    public static function isServerRequestCreatorAvailable(): bool
    {
        return (
            static::$serverRequestCreatorClass
            && static::$serverRequestCreatorMethod
            && class_exists(static::$serverRequestCreatorClass)
        );
    }
}
