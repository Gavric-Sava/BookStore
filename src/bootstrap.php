<?php

require __DIR__ . '/../vendor/autoload.php';

require 'session.php';

use Logeecom\Bookstore\presentation\routers\Router;

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'], 'database.env');
$dotenv->load();

(new Router())->route();