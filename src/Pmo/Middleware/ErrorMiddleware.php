<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Middleware;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Pmo\Exception\HttpException;
use Pmo\Handlers\ErrorHandler;
use Pmo\Interfaces\CallableResolverInterface;
use Pmo\Interfaces\ErrorHandlerInterface;
use Throwable;

class ErrorMiddleware implements MiddlewareInterface
{
    /**
     * @var CallableResolverInterface
     */
    protected $callableResolver;

    /**
     * @var ResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * @var bool
     */
    protected $displayErrorDetails;

    /**
     * @var bool
     */
    protected $logErrors;

    /**
     * @var bool
     */
    protected $logErrorDetails;

    /**
     * @var array
     */
    protected $handlers = [];

    /**
     * @var ErrorHandlerInterface|callable|null
     */
    protected $defaultErrorHandler;

    /**
     * @param CallableResolverInterface $callableResolver
     * @param ResponseFactoryInterface  $responseFactory
     * @param bool                      $displayErrorDetails
     * @param bool                      $logErrors
     * @param bool                      $logErrorDetails
     */
    public function __construct(
        CallableResolverInterface $callableResolver,
        ResponseFactoryInterface $responseFactory,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ) {
        $this->callableResolver = $callableResolver;
        $this->responseFactory = $responseFactory;
        $this->displayErrorDetails = $displayErrorDetails;
        $this->logErrors = $logErrors;
        $this->logErrorDetails = $logErrorDetails;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $e) {
            return $this->handleException($request, $e);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param Throwable              $exception
     * @return ResponseInterface
     */
    public function handleException(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        if ($exception instanceof HttpException) {
            $request = $exception->getRequest();
        }

        $exceptionType = get_class($exception);
        $handler = $this->getErrorHandler($exceptionType);

        return $handler($request, $exception, $this->displayErrorDetails, $this->logErrors, $this->logErrorDetails);
    }

    /**
     * Get callable to handle scenarios where an error
     * occurs when processing the current request.
     *
     * @param string $type Exception/Throwable name. ie: RuntimeException::class
     * @return callable|ErrorHandler
     */
    public function getErrorHandler(string $type)
    {
        if (isset($this->handlers[$type])) {
            return $this->callableResolver->resolve($this->handlers[$type]);
        }

        return $this->getDefaultErrorHandler();
    }

    /**
     * Get default error handler
     *
     * @return ErrorHandler|callable
     */
    public function getDefaultErrorHandler()
    {
        if ($this->defaultErrorHandler === null) {
            $this->defaultErrorHandler = new ErrorHandler($this->callableResolver, $this->responseFactory);
        }

        return $this->callableResolver->resolve($this->defaultErrorHandler);
    }

    /**
     * Set callable as the default Pmo application error handler.
     *
     * The callable signature MUST match the ErrorHandlerInterface
     *
     * @see \Pmo\Interfaces\ErrorHandlerInterface
     *
     * 1. Instance of \Psr\Http\Message\ServerRequestInterface
     * 2. Instance of \Throwable
     * 3. Boolean displayErrorDetails
     * 4. Boolean $logErrors
     * 5. Boolean $logErrorDetails
     *
     * The callable MUST return an instance of
     * \Psr\Http\Message\ResponseInterface.
     *
     * @param callable|ErrorHandler $handler
     * @return self
     */
    public function setDefaultErrorHandler($handler): self
    {
        $this->defaultErrorHandler = $handler;
        return $this;
    }

    /**
     * Set callable to handle scenarios where an error
     * occurs when processing the current request.
     *
     * The callable signature MUST match the ErrorHandlerInterface
     *
     * @see \Pmo\Interfaces\ErrorHandlerInterface
     *
     * 1. Instance of \Psr\Http\Message\ServerRequestInterface
     * 2. Instance of \Throwable
     * 3. Boolean displayErrorDetails
     * 4. Boolean $logErrors
     * 5. Boolean $logErrorDetails
     *
     * The callable MUST return an instance of
     * \Psr\Http\Message\ResponseInterface.
     *
     * @param string                         $type Exception/Throwable name. ie: RuntimeException::class
     * @param callable|ErrorHandlerInterface $handler
     * @return self
     */
    public function setErrorHandler(string $type, $handler): self
    {
        $this->handlers[$type] = $handler;
        return $this;
    }
}
