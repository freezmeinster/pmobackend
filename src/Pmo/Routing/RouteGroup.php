<?php
/**
 * Pmo Framework (https://slimframework.com)
 *
 * @license https://github.com/slimphp/Pmo/blob/4.x/LICENSE.md (MIT License)
 */

declare(strict_types=1);

namespace Pmo\Routing;

use Psr\Http\Server\MiddlewareInterface;
use Pmo\Interfaces\AdvancedCallableResolverInterface;
use Pmo\Interfaces\CallableResolverInterface;
use Pmo\Interfaces\RouteCollectorProxyInterface;
use Pmo\Interfaces\RouteGroupInterface;
use Pmo\MiddlewareDispatcher;

class RouteGroup implements RouteGroupInterface
{
    /**
     * @var callable|string
     */
    protected $callable;

    /**
     * @var CallableResolverInterface
     */
    protected $callableResolver;

    /**
     * @var RouteCollectorProxyInterface
     */
    protected $routeCollectorProxy;

    /**
     * @var MiddlewareInterface[]|string[]|callable[]
     */
    protected $middleware = [];

    /**
     * @var string
     */
    protected $pattern;

    /**
     * @param string                       $pattern
     * @param callable|string              $callable
     * @param CallableResolverInterface    $callableResolver
     * @param RouteCollectorProxyInterface $routeCollectorProxy
     */
    public function __construct(
        string $pattern,
        $callable,
        CallableResolverInterface $callableResolver,
        RouteCollectorProxyInterface $routeCollectorProxy
    ) {
        $this->pattern = $pattern;
        $this->callable = $callable;
        $this->callableResolver = $callableResolver;
        $this->routeCollectorProxy = $routeCollectorProxy;
    }

    /**
     * {@inheritdoc}
     */
    public function collectRoutes(): RouteGroupInterface
    {
        if ($this->callableResolver instanceof AdvancedCallableResolverInterface) {
            $callable = $this->callableResolver->resolveRoute($this->callable);
        } else {
            $callable = $this->callableResolver->resolve($this->callable);
        }
        $callable($this->routeCollectorProxy);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function add($middleware): RouteGroupInterface
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addMiddleware(MiddlewareInterface $middleware): RouteGroupInterface
    {
        $this->middleware[] = $middleware;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function appendMiddlewareToDispatcher(MiddlewareDispatcher $dispatcher): RouteGroupInterface
    {
        foreach ($this->middleware as $middleware) {
            $dispatcher->add($middleware);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }
}
