<?php

namespace Logeecom\Bookstore\presentation\single_page\controllers;

use Logeecom\Bookstore\business\logic\BookLogic;
use Logeecom\Bookstore\presentation\interfaces\ControllerInterface;
use Logeecom\Bookstore\presentation\multi_page\controllers\MultiPageBookController;
use Logeecom\Bookstore\presentation\util\RequestUtil;
use Logeecom\Bookstore\presentation\util\Validator;

class SinglePageBookController implements ControllerInterface
{

    private const REQUEST_CREATE = '/^\/spa\/books\/create\/?$/';
    private const REQUEST_EDIT = '/^\/spa\/books\/edit\/(\d+)\/?$/';
    private const REQUEST_DELETE = '/^\/spa\/books\/delete\/(\d+)\/?$/';
    private const REQUEST_LIST = '/^\/spa\/books\/?$/';

    private BookLogic $bookLogic;

    public function __construct(
        BookLogic $bookLogic
    ) {
        $this->bookLogic = $bookLogic;
    }

    public function process(string $path): void
    {
        if (preg_match(SinglePageBookController::REQUEST_CREATE, $path)) {
            $this->processBookCreate();
        } elseif (preg_match(SinglePageBookController::REQUEST_EDIT, $path, $matches)) {
            $this->processBookEdit($matches[1]);
        } elseif (preg_match(SinglePageBookController::REQUEST_DELETE, $path, $matches)) {
            $this->processBookDelete($matches[1]);
        } elseif (preg_match(SinglePageBookController::REQUEST_LIST, $path)) {
            $this->processBookList();
        } else {
            RequestUtil::render404();
        }
    }

    private function processBookList(): void
    {
        $books = $this->bookLogic->fetchAllBooks();
        include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_list.php");
    }

    private function processBookCreate(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = SinglePageBookController::validateFormInput($title, $year);

            if (empty($errors)) {
                $this->bookLogic->createBook($title, $year);
                header('Location: http://bookstore.test/books');
            } else {
                $title_error = $errors["title_error"];
                $year_error = $errors["year_error"];

                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_create.php");
            }
        } else {
            include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_create.php");
        }
    }

    private function processBookEdit(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = SinglePageBookController::validateFormInput($title, $year);

            if (empty($errors)) {
                $this->bookLogic->editBook($id, $title, $year);
                header('Location: http://bookstore.test/books');
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
                include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/books/book_delete.php");
            }
        }
    }

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