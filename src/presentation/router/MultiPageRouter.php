<?php

namespace Logeecom\Bookstore\presentation\router;

use Logeecom\Bookstore\business\logic\AuthorLogic;
use Logeecom\Bookstore\business\logic\BookLogic;
use Logeecom\Bookstore\data_access\repositories\authors\AuthorRepositoryDatabase;
use Logeecom\Bookstore\data_access\repositories\books\BookRepositoryDatabase;
use Logeecom\Bookstore\presentation\multi_page\controllers\MultiPageAuthorController;
use Logeecom\Bookstore\presentation\multi_page\controllers\MultiPageBookController;
use Logeecom\Bookstore\presentation\util\RequestUtil;
use PDO;

class MultiPageRouter extends BaseRouter
{

    private const REQUEST_AUTHOR = '/^\/(?:authors(?:\/.*)*)?$/';
    private const REQUEST_BOOK = '/^\/books(?:\/.*)*$/';

    public function route(string $request_path): void {
        // TODO move PDO into database repository constructors?
        $PDO = new PDO('mysql:host=localhost;dbname=bookstore_db', "bookstore_user", "password");

        if (preg_match(MultiPageRouter::REQUEST_AUTHOR, $request_path)) {
            // TODO dependency waterfall
            (new MultiPageAuthorController(
                new AuthorLogic(
                    new AuthorRepositoryDatabase($PDO)
                )
            ))->process($request_path);
        } elseif (preg_match(MultiPageRouter::REQUEST_BOOK, $request_path)) {
            // TODO dependency waterfall
            (new MultiPageBookController(
                new BookLogic(
                    new BookRepositoryDatabase($PDO)
                )
            ))->process($request_path);
        } else {
            RequestUtil::render404();
        }
    }
}