<?php

namespace Logeecom\Bookstore\presentation\routers;

use Logeecom\Bookstore\presentation\interfaces\RouterInterface;

class BaseRouter implements RouterInterface
{

    private const REQUEST_SINGLE = '/^\/spa(?:\/.*)*/';

    public function route(string $request_path): void {
        if (preg_match(BaseRouter::REQUEST_SINGLE, $request_path)) {
            (new SinglePageRouter())->route($request_path);
        } else {
            (new MultiPageRouter())->route($request_path);
        }
    }
}