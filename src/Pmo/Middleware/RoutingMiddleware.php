<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;
use Pmo\Exception\HttpMethodNotAllowedException;
use Pmo\Exception\HttpNotFoundException;
use Pmo\Interfaces\RouteParserInterface;
use Pmo\Interfaces\RouteResolverInterface;
use Pmo\Routing\RoutingResults;

class RoutingMiddleware implements MiddlewareInterface
{
    /**
     * @var RouteResolverInterface
     */
    protected $routeResolver;

    /**
     * @var RouteParserInterface
     */
    protected $routeParser;

    /**
     * @param RouteResolverInterface $routeResolver
     * @param RouteParserInterface   $routeParser
     */
    public function __construct(RouteResolverInterface $routeResolver, RouteParserInterface $routeParser)
    {
        $this->routeResolver = $routeResolver;
        $this->routeParser = $routeParser;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     *
     * @throws HttpNotFoundException
     * @throws HttpMethodNotAllowedException
     * @throws RuntimeException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $request->withAttribute('routeParser', $this->routeParser);
        $request = $this->performRouting($request);
        return $handler->handle($request);
    }

    /**
     * Perform routing
     *
     * @param  ServerRequestInterface $request PSR7 Server Request
     * @return ServerRequestInterface
     *
     * @throws HttpNotFoundException
     * @throws HttpMethodNotAllowedException
     * @throws RuntimeException
     */
    public function performRouting(ServerRequestInterface $request): ServerRequestInterface
    {
        $routingResults = $this->routeResolver->computeRoutingResults(
            $request->getUri()->getPath(),
            $request->getMethod()
        );
        $routeStatus = $routingResults->getRouteStatus();

        $request = $request->withAttribute('routingResults', $routingResults);

        switch ($routeStatus) {
            case RoutingResults::FOUND:
                $routeArguments = $routingResults->getRouteArguments();
                $routeIdentifier = $routingResults->getRouteIdentifier() ?? '';
                $route = $this->routeResolver
                    ->resolveRoute($routeIdentifier)
                    ->prepare($routeArguments);
                return $request->withAttribute('route', $route);

            case RoutingResults::NOT_FOUND:
                throw new HttpNotFoundException($request);

            case RoutingResults::METHOD_NOT_ALLOWED:
                $exception = new HttpMethodNotAllowedException($request);
                $exception->setAllowedMethods($routingResults->getAllowedMethods());
                throw $exception;

            default:
                throw new RuntimeException('An unexpected error occurred while performing routing.');
        }
    }
}
