<?php

namespace Logeecom\Bookstore\presentation\router;

use Logeecom\Bookstore\business\logic\AuthorLogic;
use Logeecom\Bookstore\business\logic\BookLogic;
use Logeecom\Bookstore\data_access\repositories\authors\AuthorRepositoryDatabase;
use Logeecom\Bookstore\data_access\repositories\books\BookRepositoryDatabase;
use Logeecom\Bookstore\presentation\single_page\backend\controllers\SinglePageAuthorController;
use Logeecom\Bookstore\presentation\single_page\backend\controllers\SinglePageBookController;
use Logeecom\Bookstore\presentation\util\RequestUtil;
use PDO;

class SinglePageRouter extends BaseRouter
{
    private const REQUEST_AUTHOR = '/^\/spa(?:\/authors(?:\/.*)*)?$/';
    private const REQUEST_BOOK = '/^\/spa\/authors\/(?:\d+)\/books(?:\/.*)*$/';

    public function route(string $request_path): void {
        // TODO move PDO into database repository constructors?
        $PDO = new PDO('mysql:host=localhost;dbname=bookstore_db', "bookstore_user", "password");

        if (preg_match(SinglePageRouter::REQUEST_BOOK, $request_path)) {
            // TODO dependency waterfall
            (new SinglePageBookController(
                new BookLogic(
                    new BookRepositoryDatabase($PDO)
                )
            ))->process($request_path);
        } elseif (preg_match(SinglePageRouter::REQUEST_AUTHOR, $request_path)) {
            // TODO dependency waterfall
            (new SinglePageAuthorController(
                new AuthorLogic(
                    new AuthorRepositoryDatabase($PDO)
                )
            ))->process($request_path);
        } else {
            RequestUtil::render404();
        }
    }
}