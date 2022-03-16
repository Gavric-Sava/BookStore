<?php

namespace Bookstore;

require_once './src/init.php';
require_once './src/controllers/AuthorController.php';
require_once './src/controllers/BookController.php';
require_once './src/data/repositories/authors/AuthorRepositorySession.php';
require_once './src/data/repositories/books/BookRepositorySession.php';
require_once './src/util/RequestUtil.php';

use Bookstore\Controller\AuthorController;
use Bookstore\Controller\BookController;
use Bookstore\Data\Repository\AuthorRepositorySession;
use Bookstore\Data\Repository\BookRepositorySession;
use Bookstore\Util\RequestUtil;

session_start();
initSessionData();

$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('/^\/(?:authors(?:\/.*)*)?$/', $request_path)) {
    (new AuthorController(
        new AuthorRepositorySession(),
        new BookRepositorySession())
    )->process($request_path);
} elseif (preg_match('/^\/books(?:\/.*)*$/', $request_path)) {
    (new BookController(
        new AuthorRepositorySession(),
        new BookRepositorySession())
    )->process($request_path);
} else {
    RequestUtil::render404();
}