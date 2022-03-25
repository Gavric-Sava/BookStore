<?php

namespace Logeecom\Bookstore\presentation\routers;

use Logeecom\Bookstore\presentation\interfaces\RouterInterface;

class BaseRouter implements RouterInterface
{

    /**
     * Regex for SPA request path.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private const REQUEST_SINGLE = '/^\/spa(?:\/.*)*/';

    /**
     * Route execution to appropriate controller depending on whether the request is for SPA or multi-page presentation.
     *
     * @param string $request_path - Path of the request.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function route(string $request_path): void
    {
        if (preg_match(BaseRouter::REQUEST_SINGLE, $request_path)) {
            (new SinglePageRouter())->route($request_path);
        } else {
            (new MultiPageRouter())->route($request_path);
        }
    }
}