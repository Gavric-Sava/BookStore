<?php

namespace Logeecom\Bookstore\presentation\router;

use Logeecom\Bookstore\presentation\controllers\AuthorController;
use Logeecom\Bookstore\presentation\controllers\BookController;
use Logeecom\Bookstore\data_access\repositories\authors\AuthorRepositorySession;
use Logeecom\Bookstore\data_access\repositories\authors\AuthorRepositoryDatabase;
use Logeecom\Bookstore\data_access\repositories\books\BookRepositorySession;
use Logeecom\Bookstore\data_access\repositories\books\BookRepositoryDatabase;
use Logeecom\Bookstore\presentation\util\RequestUtil;
use Logeecom\Bookstore\business\logic\AuthorLogic;
use Logeecom\Bookstore\business\logic\BookLogic;
use \PDO;

class Router
{

    private const REQUEST_AUTHOR = '/^\/(?:authors(?:\/.*)*)?$/';
    private const REQUEST_BOOK = '/^\/books(?:\/.*)*$/';

    public function route(string $request_path): void {
        // TODO move PDO into database repository constructors?
        $PDO = new PDO('mysql:host=localhost;dbname=bookstore_db', "bookstore_user", "password");

        if (preg_match(Router::REQUEST_AUTHOR, $request_path)) {
            // TODO dependency waterfall
            (new AuthorController(
                new AuthorLogic(
                    new AuthorRepositoryDatabase($PDO)
                )
            ))->process($request_path);
        } elseif (preg_match(Router::REQUEST_BOOK, $request_path)) {
            // TODO dependency waterfall
            (new BookController(
                new BookLogic(
                    new BookRepositoryDatabase($PDO)
                )
            ))->process($request_path);
        } else {
            RequestUtil::render404();
        }
    }
}