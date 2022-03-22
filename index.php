<?php

require 'vendor/autoload.php';

use Logeecom\Bookstore\controllers\AuthorController;
use Logeecom\Bookstore\controllers\BookController;
use Logeecom\Bookstore\data\repositories\authors\AuthorRepositorySession;
use Logeecom\Bookstore\data\repositories\authors\AuthorRepositoryDatabase;
use Logeecom\Bookstore\data\repositories\books\BookRepositorySession;
use Logeecom\Bookstore\data\repositories\books\BookRepositoryDatabase;
use Logeecom\Bookstore\util\RequestUtil;

session_start();
//initSessionData();

$PDO = new PDO('mysql:host=localhost;dbname=bookstore_db', "bookstore_user", "password");

$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('/^\/(?:authors(?:\/.*)*)?$/', $request_path)) {
    (new AuthorController(
        new AuthorRepositoryDatabase($PDO)
    ))->process($request_path);
} elseif (preg_match('/^\/books(?:\/.*)*$/', $request_path)) {
    (new BookController(
        new BookRepositoryDatabase($PDO)
    ))->process($request_path);
} else {
    RequestUtil::render404();
}