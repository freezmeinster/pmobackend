<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Interfaces;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface MiddlewareDispatcherInterface extends RequestHandlerInterface
{
    /**
     * Add a new middleware to the stack
     *
     * Middleware are organized as a stack. That means middleware
     * that have been added before will be executed after the newly
     * added one (last in, first out).
     *
     * @param MiddlewareInterface|string|callable $middleware
     * @return self
     */
    public function add($middleware): self;

    /**
     * Add a new middleware to the stack
     *
     * Middleware are organized as a stack. That means middleware
     * that have been added before will be executed after the newly
     * added one (last in, first out).
     *
     * @param MiddlewareInterface $middleware
     * @return self
     */
    public function addMiddleware(MiddlewareInterface $middleware): self;

    /**
     * Seed the middleware stack with the inner request handler
     *
     * @param RequestHandlerInterface $kernel
     * @return void
     */
    public function seedMiddlewareStack(RequestHandlerInterface $kernel): void;
}
