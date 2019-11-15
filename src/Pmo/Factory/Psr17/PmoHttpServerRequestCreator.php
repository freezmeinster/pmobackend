<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Pmo\Factory\Psr17;

use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use Pmo\Interfaces\ServerRequestCreatorInterface;

class PmoHttpServerRequestCreator implements ServerRequestCreatorInterface
{
    /**
     * @var ServerRequestCreatorInterface
     */
    protected $serverRequestCreator;

    /**
     * @var string
     */
    protected static $serverRequestDecoratorClass = 'Pmo\Http\ServerRequest';

    /**
     * @param ServerRequestCreatorInterface $serverRequestCreator
     */
    public function __construct(ServerRequestCreatorInterface $serverRequestCreator)
    {
        $this->serverRequestCreator = $serverRequestCreator;
    }

    /**
     * {@inheritdoc}
     */
    public function createServerRequestFromGlobals(): ServerRequestInterface
    {
        if (!static::isServerRequestDecoratorAvailable()) {
            throw new RuntimeException('The Pmo-Http ServerRequest decorator is not available.');
        }

        $request = $this->serverRequestCreator->createServerRequestFromGlobals();

        return new static::$serverRequestDecoratorClass($request);
    }

    /**
     * @return bool
     */
    public static function isServerRequestDecoratorAvailable(): bool
    {
        return class_exists(static::$serverRequestDecoratorClass);
    }
}
