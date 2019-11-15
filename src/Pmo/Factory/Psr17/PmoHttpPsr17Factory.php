<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Factory\Psr17;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PmoHttpPsr17Factory extends Psr17Factory
{
    protected static $responseFactoryClass = 'Pmo\Http\Factory\DecoratedResponseFactory';

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param StreamFactoryInterface   $streamFactory
     * @return ResponseFactoryInterface
     */
    public static function createDecoratedResponseFactory(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory
    ): ResponseFactoryInterface {
        return new static::$responseFactoryClass($responseFactory, $streamFactory);
    }
}
