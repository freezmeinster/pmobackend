<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Pmo\Factory\Psr17;

class GuzzlePsr17Factory extends Psr17Factory
{
    protected static $responseFactoryClass = 'Http\Factory\Guzzle\ResponseFactory';
    protected static $streamFactoryClass = 'Http\Factory\Guzzle\StreamFactory';
    protected static $serverRequestCreatorClass = 'GuzzleHttp\Psr7\ServerRequest';
    protected static $serverRequestCreatorMethod = 'fromGlobals';
}
