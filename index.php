<?php

require_once './src/init.php';
require_once './src/controllers/AuthorController.php';
require_once './src/util/PathParser.php';

session_start();
initSessionData();

$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// TODO parse path...

switch ($request_path) {
    case '/':
    case '':
    case '/authors':
        (new AuthorController())->process($request_path);
        break;
    default:
        http_response_code(404);
        require($_SERVER['DOCUMENT_ROOT'] . "/src/views/404.php");
}