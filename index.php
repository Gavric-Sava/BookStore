<?php

require 'vendor/autoload.php';
//require 'src/bootstrap.php';

use Logeecom\Bookstore\presentation\router\BaseRouter;

// TODO comments;
// TODO refactor links to assets
// TODO refactor validation code - like SinglePageAuthorController

$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
(new BaseRouter())->route($request_path);