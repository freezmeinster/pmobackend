<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Pmo\Error;

use Pmo\Interfaces\ErrorRendererInterface;

/**
 * Abstract Pmo application error renderer
 *
 * It outputs the error message and diagnostic information in one of the following formats:
 * JSON, XML, Plain Text or HTML
 */
abstract class AbstractErrorRenderer implements ErrorRendererInterface
{
}
