<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/src/init.php";
    session_start();
    initSessionData();
    require_once $_SERVER['DOCUMENT_ROOT']."/src/controllers/AuthorController.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/src/util/PathParser.php";

    $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//    print_r($request_path);
    // TODO parse path...
//    $dir_name = pathinfo($request_path, PATHINFO_BASENAME);
//    print_r($dir_name);
//    $first_path = PathParser::tokenizePath($request_path);

//    print_r($_SERVER["HTTP_HOST"]);
    switch ($request_path) {
        case '/':
        case '':
        case '/authors':
            (new AuthorController())->process($request_path);
            break;
        default:
            http_response_code(404);
            require ($_SERVER['DOCUMENT_ROOT']."/src/views/404.php");
    }

