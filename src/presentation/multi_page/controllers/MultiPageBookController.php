<?php

namespace Logeecom\Bookstore\presentation\multi_page\controllers;

use Logeecom\Bookstore\business\logic\BookLogic;
use Logeecom\Bookstore\presentation\interfaces\BaseBookController;
use Logeecom\Bookstore\presentation\interfaces\ControllerInterface;
use Logeecom\Bookstore\presentation\util\RequestUtil;

class MultiPageBookController extends BaseBookController
{

    private const REQUEST_CREATE = '/^\/authors\/(\d*)\/books\/create\/?$/';
    private const REQUEST_EDIT = '/^\/authors\/(\d*)\/books\/edit\/(\d+)\/?$/';
    private const REQUEST_DELETE = '/^\/authors\/(\d*)\/books\/delete\/(\d+)\/?$/';
    private const REQUEST_LIST = '/^\/authors\/(\d*)\/(?:books)?\/?$/';

    private BookLogic $bookLogic;

    public function __construct(
        BookLogic $bookLogic
    ) {
        $this->bookLogic = $bookLogic;
    }

    public function process(string $path): void
    {
        if (preg_match(MultiPageBookController::REQUEST_CREATE, $path, $matches)) {
            $this->processBookCreate($matches[1]);
        } elseif (preg_match(MultiPageBookController::REQUEST_EDIT, $path, $matches)) {
            $this->processBookEdit($matches[2]);
        } elseif (preg_match(MultiPageBookController::REQUEST_DELETE, $path, $matches)) {
            $this->processBookDelete($matches[2]);
        } elseif (preg_match(MultiPageBookController::REQUEST_LIST, $path, $matches)) {
            $this->processBookList($matches[1]);
        } else {
            RequestUtil::render404();
        }
    }

    /**
     * Implementation of the 'Book list' use case.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected function processBookList(int $author_id): void
    {
        $books = $this->bookLogic->fetchAllBooksFromAuthor($author_id);
        include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_list.php");
    }

    /**
     * Implementation of the 'Book create' use case.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected function processBookCreate(int $author_id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = $this->validateFormInput($title, $year);

            if (empty($errors)) {
                $this->bookLogic->createBook($title, $year, $author_id);
                header("Location: http://bookstore.test/authors/{$author_id}/books");
            } else {
                $title_error = $errors["title_error"];
                $year_error = $errors["year_error"];

                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_create.php");
            }
        } else {
            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_create.php");
        }
    }

    /**
     * Implementation of the 'Book edit' use case.
     *
     * @param int $id Id of the book to be edited.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected function processBookEdit(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = $this->validateFormInput($title, $year);

            if (empty($errors)) {
                // TODO return book
                $this->bookLogic->editBook($id, $title, $year);
                $book = $this->bookLogic->fetchBook($id);

                header("Location: http://bookstore.test/authors/{$book->getAuthorId()}/books");
            } else {
                $title_error = $errors["title_error"];
                $year_error = $errors["year_error"];

                $book = $this->bookLogic->fetchBook($id);
                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_edit.php");
            }
        } else {
            $book = $this->bookLogic->fetchBook($id);
            if (!isset($book)) {
                RequestUtil::render404();
            } else {
                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_edit.php");
            }
        }
    }

    /**
     * Implementation of the 'Book delete' use case.
     *
     * @param int $id Id of the book to be deleted.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected function processBookDelete(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // TODO check success...
            $book = $this->bookLogic->fetchBook($id);
            $this->bookLogic->deleteBook($id);

            header("Location: http://bookstore.test/authors/{$book->getAuthorId()}/books");
        } else {
            $book = $this->bookLogic->fetchBook($id);
            if (!isset($book)) {
                RequestUtil::render404();
            } else {
                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_delete.php");
            }
        }
    }

}