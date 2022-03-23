<?php

require 'vendor/autoload.php';
require 'src/bootstrap.php';

use Logeecom\Bookstore\presentation\router\BaseRouter;

// TODO add view models;
// TODO database operations failure handling;
// TODO refactor absolute path of view require to something better;
// TODO comments;
// TODO refactor links to assets

$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
(new BaseRouter())->route($request_path);