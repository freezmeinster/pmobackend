<?php
/**
 * Pmo Framework (https://)
 *
 */

declare(strict_types=1);

namespace Pmo\Exception;

class HttpMethodNotAllowedException extends HttpSpecializedException
{
    /**
     * @var array
     */
    protected $allowedMethods = [];

    protected $code = 405;
    protected $message = 'Method not allowed.';
    protected $title = '405 Method Not Allowed';
    protected $description = 'The request method is not supported for the requested resource.';

    /**
     * @return array
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }

    /**
     * @param array $methods
     * @return self
     */
    public function setAllowedMethods(array $methods): HttpMethodNotAllowedException
    {
        $this->allowedMethods = $methods;
        $this->message = 'Method not allowed. Must be one of: ' . implode(', ', $methods);
        return $this;
    }
}
