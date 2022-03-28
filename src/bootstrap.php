<?php

require __DIR__ . '/../vendor/autoload.php';

//require 'session.php';

use Logeecom\Bookstore\presentation\routers\BaseRouter;

//zasto ovde ide prosledjivanje parametra
$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
(new BaseRouter())->route($request_path);