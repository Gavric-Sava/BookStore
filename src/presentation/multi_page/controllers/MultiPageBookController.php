<?php

namespace Logeecom\Bookstore\presentation\multi_page\controllers;

use Logeecom\Bookstore\business\logic\books\BookLogic;
use Logeecom\Bookstore\data_access\DatabaseConnection;
use Logeecom\Bookstore\data_access\models\Book;
use Logeecom\Bookstore\data_access\repositories\books\BookRepositoryDatabase;
use Logeecom\Bookstore\presentation\interfaces\BaseBookController;
use Logeecom\Bookstore\presentation\util\RequestUtil;
use Logeecom\Bookstore\presentation\util\validators\GeneralValidator;

class MultiPageBookController extends BaseBookController
{
    private BookLogic $bookLogic;

    public function __construct(
//        BookLogic $bookLogic
    ) {
        $this->bookLogic = new BookLogic(new BookRepositoryDatabase(DatabaseConnection::getInstance()->getPDOConnection()));
    }

    /**
     * Fetches list of books and returns corresponding view.
     *
     * @param int $author_id - Author id.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function renderBookList(int $author_id): void
    {
        $books = $this->bookLogic->fetchAllBooksFromAuthor($author_id);
        include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_list.php");
    }

    public function processBookList(int $author_id): void
    {
        $this->renderBookList($author_id);
    }

    public function renderBookCreate(int $author_id): void
    {
        include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_create.php");
    }

    /**
     * On get returns book create form view. On post tries to create new book.
     * On error returns form view with errors.
     *
     * @param int $author_id Author id.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function processBookCreate(int $author_id): void
    {
        $title = $_POST["title"];
        $year = $_POST["year"];

        $errors = $this->validateFormInput($title, $year);

        if (empty($errors)) {
            $this->bookLogic->createBook($title, $year, $author_id);
            header(
                'Location: ' .
                $_SERVER['REQUEST_SCHEME'] .
                '://' . $_SERVER['HTTP_HOST'] .
                "/authors/{$author_id}/books");
        } else {
            $title_error = $errors["title_error"];
            $year_error = $errors["year_error"];

            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_create.php");
        }
    }

    public function renderBookEdit(int $id): void
    {
        $book = $this->bookLogic->fetchBook($id);
        if (!isset($book)) {
            RequestUtil::render404();
        } else {
            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_edit.php");
        }
    }

    /**
     * On get returns book edit form view. On post tries to edit book.
     * On error returns form view with errors.
     *
     * @param int $id Id of the book to be edited.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processBookEdit(int $id): void
    {
        $title = $_POST["title"];
        $year = $_POST["year"];

        $errors = $this->validateFormInput($title, $year);

        if (empty($errors)) {
            $this->bookLogic->editBook($id, $title, $year);
            $book = $this->bookLogic->fetchBook($id);

            header(
                'Location: ' . $_SERVER['REQUEST_SCHEME'] .
                '://' .
                $_SERVER['HTTP_HOST'] .
                "/authors/{$book->getAuthorId()}/books");
        } else {
            $book = $this->bookLogic->fetchBook($id);
            $title_error = $errors["title_error"];
            $year_error = $errors["year_error"];

            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_edit.php");
        }
    }

    public function renderBookDelete(int $id): void
    {
        $book = $this->bookLogic->fetchBook($id);
        if (!isset($book)) {
            RequestUtil::render404();
        } else {
            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_delete.php");
        }
    }

    /**
     * On get returns book delete dialog view. On post tries to delete book.
     * On error returns 404 view.
     *
     * @param int $id Id of the book to be deleted.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processBookDelete(int $id): void
    {
        $book = $this->bookLogic->fetchBook($id);
        $this->bookLogic->deleteBook($id);

        header(
            'Location: ' .
            $_SERVER['REQUEST_SCHEME'] .
            '://' .
            $_SERVER['HTTP_HOST'] .
            "/authors/{$book->getAuthorId()}/books");
    }

}