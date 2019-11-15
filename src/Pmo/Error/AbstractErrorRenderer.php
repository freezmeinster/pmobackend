<?php
/**
 * Pmo Framework (https://)
 *
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
