<?php

namespace Logeecom\Bookstore\presentation\routers;

use Logeecom\Bookstore\presentation\util\RequestUtil;

class Router
{

    public function route(): void
    {
        $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $request_method = $_SERVER['REQUEST_METHOD'];

        $mappings = include $_SERVER['DOCUMENT_ROOT'] . '/config/routes.php';

        foreach ($mappings as $mapping) {
            if ($mapping->matches($request_path, $request_method)) {
                $mapping->process();
                return;
            }
        }

        RequestUtil::render404();
    }
}