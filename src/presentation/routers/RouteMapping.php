<?php

namespace Logeecom\Bookstore\presentation\routers;

use Closure;

class RouteMapping
{
    /**
     * @var string - Regex pattern for request path.
     */
    private string $pathPattern;
    /**
     * @var string - Name of controller class to be instantiated on path match.
     */
    private string $controller;
    /**
     * @var string - Name of method of controller class to be called.
     */
    private string $method;
    /**
     * @var string - Accepted request method.
     */
    private string $requestMethod;
    /**
     * @var array - Parameters to be passed to controller method.
     */
    private array $parameters;
    /**
     * @var Closure - Controller dependencies.
     */
    private Closure $dependency;

    public function __construct(
        string $pathPattern,
        string $controller,
        string $method,
        string $requestMethod,
        callable $dependency
    ) {
        $this->pathPattern = $pathPattern;
        $this->controller = $controller;
        $this->method = $method;
        $this->requestMethod = $requestMethod;
        $this->parameters = [];
        $this->dependency = $dependency;
    }

    /**
     * Check if request matches with parameters of the mapping.
     * @param string $requestPath - Path of request.
     * @param string $requestMethod - HTTP Method of request.
     * @return bool
     */
    public function matches(string $requestPath, string $requestMethod): bool
    {
        if (
            $requestMethod === $this->requestMethod
            &&
            preg_match($this->pathPattern, $requestPath, $this->parameters)
        ) {
            array_shift($this->parameters);

            return true;
        }

        return false;
    }

    /**
     * Process request with mapping's controller's method.
     * @return void
     */
    public function process(): void
    {
        call_user_func_array(
            array(new $this->controller(...(($this->dependency)())), $this->method),
            $this->parameters
        );
    }

}