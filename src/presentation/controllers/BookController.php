<?php

namespace Logeecom\Bookstore\presentation\controllers;

use Logeecom\Bookstore\business\logic\BookLogic;
use Logeecom\Bookstore\presentation\util\RequestUtil;
use Logeecom\Bookstore\presentation\util\Validator;

class BookController extends BaseController
{

    private const REQUEST_CREATE = '/^\/books\/create\/?$/';
    private const REQUEST_EDIT = '/^\/books\/edit\/(\d+)\/?$/';
    private const REQUEST_DELETE = '/^\/books\/delete\/(\d+)\/?$/';
    private const REQUEST_LIST = '/^\/books\/?$/';

    private BookLogic $bookLogic;

    public function __construct(
        BookLogic $bookLogic
    ) {
        $this->bookLogic = $bookLogic;
    }

    public function process(string $path): void
    {
        if (preg_match(BookController::REQUEST_CREATE, $path)) {
            $this->processBookCreate();
        } elseif (preg_match(BookController::REQUEST_EDIT, $path, $matches)) {
            $this->processBookEdit($matches[1]);
        } elseif (preg_match(BookController::REQUEST_DELETE, $path, $matches)) {
            $this->processBookDelete($matches[1]);
        } elseif (preg_match(BookController::REQUEST_LIST, $path)) {
            $this->processBookList();
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
    private function processBookList(): void
    {
        $books = $this->bookLogic->fetchAllBooks();
        include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/views/books/book_list.php");
    }

    /**
     * Implementation of the 'Book create' use case.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private function processBookCreate(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = BookController::validateFormInput($title, $year);

            if (empty($errors)) {
                $this->bookLogic->createBook($title, $year);
                header('Location: http://bookstore.test/books');
            } else {
                $title_error = $errors["title_error"];
                $year_error = $errors["year_error"];

                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/views/books/book_create.php");
            }
        } else {
            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/views/books/book_create.php");
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
    private function processBookEdit(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = BookController::validateFormInput($title, $year);

            if (empty($errors)) {
                $this->bookLogic->editBook($id, $title, $year);
                header('Location: http://bookstore.test/books');
            } else {
                $title_error = $errors["title_error"];
                $year_error = $errors["year_error"];

                $book = $this->bookLogic->fetchBook($id);
                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/views/books/book_edit.php");
            }
        } else {
            $book = $this->bookLogic->fetchBook($id);
            if (!isset($book)) {
                RequestUtil::render404();
            } else {
                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/views/books/book_edit.php");
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
    public function processBookDelete(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->bookLogic->deleteBook($id);

            header('Location: http://bookstore.test/books');
        } else {
            $book = $this->bookLogic->fetchBook($id);
            if (!isset($book)) {
                RequestUtil::render404();
            } else {
                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/views/books/book_delete.php");
            }
        }
    }

    /**
     * Validation of input form data_access for 'Book create' and 'Book edit' use cases.
     *
     * @param mixed $title Title of the book to be created/edited.
     * @param mixed $year Year of the book to be created/edited.
     * @return string[]|null List of errors or null, if no errors occurred.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private static function validateFormInput($title, $year): ?array
    {
        $title_error = "";
        $year_error = "";

        if (!Validator::validateNotEmpty($title)) {
            $title_error = "Title is required.";
        } else {
            $title = Validator::sanitizeData($title);
            if (!Validator::validateAlphanumeric($title)) {
                $title_error = "Title is not in a valid format.";
            }
        }

        if (!Validator::validateNotEmpty($year)) {
            $year_error = "Year is required.";
        } else {
            $year = Validator::sanitizeData($year);
            if (!Validator::validateNumber($year)) {
                $year_error = "Year is not in a valid format.";
            }
        }

        if (!($title_error == "" && $year_error == "")) {
            return [
                "title_error" => $title_error,
                "year_error" => $year_error
            ];
        }

        return null;
    }
}