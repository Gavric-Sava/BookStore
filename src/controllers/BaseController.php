<?php

namespace Bookstore\Controller;

abstract class BaseController
{
    /**
     * Parses path and processes the request.
     *
     * @param string $path Path of the request.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    abstract public function process(string $path): void;
}