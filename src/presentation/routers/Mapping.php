<?php

namespace Logeecom\Bookstore\presentation\routers;

use Closure;

class Mapping
{
    private string $pathPattern;
    private string $controller;
    private string $method;
    private string $requestMethod;
    private array $parameters;
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

    public function matches(string $requestPath, string $requestMethod): bool
    {
        $ret = (
            $requestMethod === $this->requestMethod
            &&
            preg_match($this->pathPattern, $requestPath, $this->parameters)
        );

        if ($ret) {
            array_shift($this->parameters);
        }

        return $ret;
    }

    public function process(): void
    {
        call_user_func_array(array(new $this->controller(($this->dependency)()), $this->method), $this->parameters);
    }

}