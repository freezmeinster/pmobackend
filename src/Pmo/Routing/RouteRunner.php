<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Routing;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Pmo\Exception\HttpMethodNotAllowedException;
use Pmo\Exception\HttpNotFoundException;
use Pmo\Interfaces\RouteCollectorProxyInterface;
use Pmo\Interfaces\RouteParserInterface;
use Pmo\Interfaces\RouteResolverInterface;
use Pmo\Middleware\RoutingMiddleware;

class RouteRunner implements RequestHandlerInterface
{
    /**
     * @var RouteResolverInterface
     */
    private $routeResolver;

    /**
     * @var RouteParserInterface
     */
    private $routeParser;

    /**
     * @var RouteCollectorProxyInterface|null
     */
    private $routeCollectorProxy;

    /**
     * @param RouteResolverInterface            $routeResolver
     * @param RouteParserInterface              $routeParser
     * @param RouteCollectorProxyInterface|null $routeCollectorProxy
     */
    public function __construct(
        RouteResolverInterface $routeResolver,
        RouteParserInterface $routeParser,
        ?RouteCollectorProxyInterface $routeCollectorProxy = null
    ) {
        $this->routeResolver = $routeResolver;
        $this->routeParser = $routeParser;
        $this->routeCollectorProxy = $routeCollectorProxy;
    }

    /**
     * This request handler is instantiated automatically in App::__construct()
     * It is at the very tip of the middleware queue meaning it will be executed
     * last and it detects whether or not routing has been performed in the user
     * defined middleware stack. In the event that the user did not perform routing
     * it is done here
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws HttpNotFoundException
     * @throws HttpMethodNotAllowedException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // If routing hasn't been done, then do it now so we can dispatch
        if ($request->getAttribute('routingResults') === null) {
            $routingMiddleware = new RoutingMiddleware($this->routeResolver, $this->routeParser);
            $request = $routingMiddleware->performRouting($request);
        }

        if ($this->routeCollectorProxy !== null) {
            $request = $request->withAttribute('basePath', $this->routeCollectorProxy->getBasePath());
        }

        /** @var Route $route */
        $route = $request->getAttribute('route');
        return $route->run($request);
    }
}
