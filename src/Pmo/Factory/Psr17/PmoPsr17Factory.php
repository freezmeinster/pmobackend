<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Factory\Psr17;

class PmoPsr17Factory extends Psr17Factory
{
    protected static $responseFactoryClass = 'Pmo\Psr7\Factory\ResponseFactory';
    protected static $streamFactoryClass = 'Pmo\Psr7\Factory\StreamFactory';
    protected static $serverRequestCreatorClass = 'Pmo\Psr7\Factory\ServerRequestFactory';
    protected static $serverRequestCreatorMethod = 'createFromGlobals';
}
