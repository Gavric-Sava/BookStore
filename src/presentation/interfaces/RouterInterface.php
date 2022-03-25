<?php

namespace Logeecom\Bookstore\presentation\interfaces;

interface RouterInterface
{
    /**
     * Route execution to appropriate controller
     *
     * @param string $request_path - Path of the request.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function route(string $request_path): void;
}