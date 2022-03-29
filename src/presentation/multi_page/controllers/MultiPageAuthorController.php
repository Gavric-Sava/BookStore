<?php

namespace Logeecom\Bookstore\presentation\multi_page\controllers;

use Logeecom\Bookstore\business\logic\authors\AuthorLogic;
use Logeecom\Bookstore\presentation\base_controllers\BaseAuthorController;
use Logeecom\Bookstore\presentation\util\RequestUtil;

class MultiPageAuthorController extends BaseAuthorController
{
    /**
     * @var AuthorLogic - Author business logic.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private AuthorLogic $authorLogic;

    public function __construct(
        AuthorLogic $authorLogic
    ) {
        $this->authorLogic = $authorLogic;
    }

    /**
     * Fetches list of authors and returns corresponding view.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function renderAuthorList(): void
    {
        $authors_with_book_count = $this->authorLogic->fetchAllAuthorsWithBookCount();

        include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/templates/authors/author_list.php");
    }

    /**
     * @inheritDoc
     */
    public function processAuthorList(): void
    {
        $this->renderAuthorList();
    }

    /**
     * On get returns author create form view. On post tries to create new author.
     * On error returns form view with errors.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function renderAuthorCreate(): void
    {
        include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/templates/authors/author_create.php");
    }

    /**
     * @inheritDoc
     */
    public function processAuthorCreate(): void
    {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];

        $errors = $this->validateFormInput($first_name, $last_name);

        if (empty($errors)) {
            $this->authorLogic->createAuthor($first_name, $last_name);
            header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
        } else {
            $first_name_error = $errors["first_name_error"];
            $last_name_error = $errors["last_name_error"];

            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/templates/authors/author_create.php");
        }
    }

    public function renderAuthorEdit(int $id): void
    {
        $author = $this->authorLogic->fetchAuthor($id);
        if (!isset($author)) {
            RequestUtil::render404();
        } else {
            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/templates/authors/author_edit.php");
        }
    }

    /**
     * On get returns author edit form view. On post tries to edit author.
     * On error returns form view with errors.
     *
     * @param int $id Id of the author to be edited.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processAuthorEdit(int $id): void
    {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];

        $errors = $this->validateFormInput(
            $first_name,
            $last_name
        );

        if (empty($errors)) {
            $this->authorLogic->editAuthor($id, $first_name, $last_name);
            header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
        } else {
            $first_name_error = $errors["first_name_error"];
            $last_name_error = $errors["last_name_error"];

            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/templates/authors/author_edit.php");
        }
    }

    public function renderAuthorDelete(int $id): void
    {
        $author = $this->authorLogic->fetchAuthor($id);
        if (!isset($author)) {
            RequestUtil::render404();
        } else {
            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/templates/authors/author_delete.php");
        }
    }

    /**
     * On get returns author delete dialog view. On post tries to delete author.
     * On error returns 404 view.
     *
     * @param int $id Id of the author to be deleted.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processAuthorDelete(int $id): void
    {
            $this->authorLogic->deleteAuthor($id);

            header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
    }

}