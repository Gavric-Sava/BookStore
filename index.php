<?php

require_once './src/init.php';
require_once './src/controllers/AuthorController.php';
require_once './src/controllers/BookController.php';
require_once './src/util/RequestUtil.php';

session_start();
initSessionData();

$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('/^\/(?:authors(?:\/.*)*)?$/', $request_path)) {
    (new AuthorController())->process($request_path);
} /*elseif (preg_match('/^\/books(?:\/.*)*$/', $request_path)) {
    (new BookController())->process($request_path);
}*/ else {
    RequestUtil::render404();
}

//switch ($exploded_path[0]) {
//    case '/':
//    case '':
//    case '/authors':
////        array_shift($tokenized_path);
//        (new AuthorController())->process($exploded_path);
//        break;
//    default:
//        http_response_code(404);
//        require($_SERVER['DOCUMENT_ROOT'] . "/src/views/404.php");
//}