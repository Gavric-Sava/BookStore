<?php

require __DIR__ . '/../vendor/autoload.php';

//require 'session.php';

use Logeecom\Bookstore\presentation\routers\Router;

(new Router())->route();