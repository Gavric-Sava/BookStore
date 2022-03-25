<?php

namespace Logeecom\Bookstore\presentation\multi_page\controllers;

use Logeecom\Bookstore\business\logic\AuthorLogic;
use Logeecom\Bookstore\presentation\interfaces\BaseAuthorController;
use Logeecom\Bookstore\presentation\util\RequestUtil;
use Logeecom\Bookstore\presentation\util\validators\GeneralValidator;

class MultiPageAuthorController extends BaseAuthorController
{

    private const REQUEST_CREATE = '/^\/authors\/create\/?$/';
    private const REQUEST_EDIT = '/^\/authors\/edit\/(\d+)\/?$/';
    private const REQUEST_DELETE = '/^\/authors\/delete\/(\d+)\/?$/';
    private const REQUEST_LIST = '/^\/(?:authors\/?)?$/';

    private AuthorLogic $authorLogic;

    public function __construct(
        AuthorLogic $authorLogic
    ) {
        $this->authorLogic = $authorLogic;
    }

    /**
     * Parses path and processes the request.
     *
     * @param string $path Path of the request.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function process(string $path): void
    {
        if (preg_match(MultiPageAuthorController::REQUEST_CREATE, $path)) {
            $this->processAuthorCreate();
        } elseif (preg_match(MultiPageAuthorController::REQUEST_EDIT, $path, $matches)) {
            $this->processAuthorEdit($matches[1]);
        } elseif (preg_match(MultiPageAuthorController::REQUEST_DELETE, $path, $matches)) {
            $this->processAuthorDelete($matches[1]);
        } elseif (preg_match(MultiPageAuthorController::REQUEST_LIST, $path)) {
            $this->processAuthorList();
        } else {
            RequestUtil::render404();
        }
    }

    /**
     * Implementation of the 'Author list' use case.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected function processAuthorList(): void
    {
        $authors_with_book_count = $this->authorLogic->fetchAllAuthorsWithBookCount();

        include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/authors/author_list.php");
    }

    /**
     * Implementation of the 'Author create' use case.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected function processAuthorCreate(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            $errors = $this->validateFormInput($first_name, $last_name);

            if (empty($errors)) {
                $this->authorLogic->createAuthor($first_name, $last_name);
                header('Location: http://bookstore.test');
            } else {
                $first_name_error = $errors["first_name_error"];
                $last_name_error = $errors["last_name_error"];

                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/authors/author_create.php");
            }
        } else {
            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/authors/author_create.php");
        }
    }

    /**
     * Implementation of the 'Author edit' use case.
     *
     * @param int $id Id of the author to be edited.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected function processAuthorEdit(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            $errors = $this->validateFormInput(
                $first_name,
                $last_name
            );

            if (empty($errors)) {
                $this->authorLogic->editAuthor($id, $first_name, $last_name);
                header('Location: http://bookstore.test');
            } else {
                $first_name_error = $errors["first_name_error"];
                $last_name_error = $errors["last_name_error"];

                $author = $this->authorLogic->fetchAuthor($id);
                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/authors/author_edit.php");
            }
        } else {
            $author = $this->authorLogic->fetchAuthor($id);
            if (!isset($author)) {
                RequestUtil::render404();
            } else {
                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/authors/author_edit.php");
            }
        }
    }

    /**
     * Implementation of the 'Author delete' use case.
     *
     * @param int $id Id of the author to be deleted.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected function processAuthorDelete(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->authorLogic->deleteAuthor($id);

            header('Location: http://bookstore.test');
        } else {
            $author = $this->authorLogic->fetchAuthor($id);
            if (!isset($author)) {
                RequestUtil::render404();
            } else {
                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/authors/author_delete.php");
            }
        }
    }

}