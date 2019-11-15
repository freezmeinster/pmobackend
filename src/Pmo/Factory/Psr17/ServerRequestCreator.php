<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Pmo\Factory\Psr17;

use Closure;
use Psr\Http\Message\ServerRequestInterface;
use Pmo\Interfaces\ServerRequestCreatorInterface;

class ServerRequestCreator implements ServerRequestCreatorInterface
{
    /**
     * @var object|string
     */
    protected $serverRequestCreator;

    /**
     * @var string
     */
    protected $serverRequestCreatorMethod;

    /**
     * @param object|string $serverRequestCreator
     * @param string        $serverRequestCreatorMethod
     */
    public function __construct($serverRequestCreator, string $serverRequestCreatorMethod)
    {
        $this->serverRequestCreator = $serverRequestCreator;
        $this->serverRequestCreatorMethod = $serverRequestCreatorMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function createServerRequestFromGlobals(): ServerRequestInterface
    {
        /** @var callable $callable */
        $callable = [$this->serverRequestCreator, $this->serverRequestCreatorMethod];
        return (Closure::fromCallable($callable))();
    }
}
