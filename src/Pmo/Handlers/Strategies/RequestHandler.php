<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Handlers\Strategies;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Pmo\Interfaces\RequestHandlerInvocationStrategyInterface;

/**
 * PSR-15 RequestHandler invocation strategy
 */
class RequestHandler implements RequestHandlerInvocationStrategyInterface
{
    /**
     * @var bool
     */
    protected $appendRouteArgumentsToRequestAttributes;

    /**
     * @param bool $appendRouteArgumentsToRequestAttributes
     */
    public function __construct(bool $appendRouteArgumentsToRequestAttributes = false)
    {
        $this->appendRouteArgumentsToRequestAttributes = $appendRouteArgumentsToRequestAttributes;
    }

    /**
     * Invoke a route callable that implements RequestHandlerInterface
     *
     * @param callable               $callable
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param array                  $routeArguments
     *
     * @return ResponseInterface
     */
    public function __invoke(
        callable $callable,
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArguments
    ): ResponseInterface {
        if ($this->appendRouteArgumentsToRequestAttributes) {
            foreach ($routeArguments as $k => $v) {
                $request = $request->withAttribute($k, $v);
            }
        }

        return $callable($request);
    }
}
