<?php

require 'vendor/autoload.php';
require 'src/bootstrap.php';

use Logeecom\Bookstore\presentation\router\BaseRouter;

// TODO add view models;
// TODO database operations failure handling;
// TODO refactor absolute path of view require to something better;
// TODO comments;
// TODO refactor links to assets
// TODO interface should go in the upper layer relative to it's implementations
// TODO refactor validation code - like SinglePageAuthorController

$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
(new BaseRouter())->route($request_path);