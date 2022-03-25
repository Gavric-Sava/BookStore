<?php

namespace Logeecom\Bookstore\presentation\single_page\backend\controllers;

use Logeecom\Bookstore\business\logic\BookLogic;
use Logeecom\Bookstore\presentation\interfaces\ControllerInterface;
use Logeecom\Bookstore\presentation\multi_page\controllers\MultiPageBookController;
use Logeecom\Bookstore\presentation\util\RequestUtil;
use Logeecom\Bookstore\presentation\util\Validator;

class SinglePageBookController implements ControllerInterface
{

    private const REQUEST_CREATE = '/^\/spa\/authors\/(\d*)\/books\/create\/?$/';
    private const REQUEST_EDIT = '/^\/spa\/authors\/(\d*)\/books\/edit\/(\d+)\/?$/';
    private const REQUEST_DELETE = '/^\/spa\/authors\/(\d*)\/books\/delete\/(\d+)\/?$/';
    private const REQUEST_LIST = '/^\/spa\/authors\/(\d*)\/(?:books)?\/?$/';

    private BookLogic $bookLogic;

    public function __construct(
        BookLogic $bookLogic
    ) {
        $this->bookLogic = $bookLogic;
    }

    public function process(string $path): void
    {
        if (preg_match(SinglePageBookController::REQUEST_CREATE, $path, $matches)) {
            $this->processBookCreate($matches[1]);
        } elseif (preg_match(SinglePageBookController::REQUEST_EDIT, $path, $matches)) {
            $this->processBookEdit($matches[2]);
        } elseif (preg_match(SinglePageBookController::REQUEST_DELETE, $path, $matches)) {
            $this->processBookDelete($matches[2]);
        } elseif (preg_match(SinglePageBookController::REQUEST_LIST, $path, $matches)) {
            $this->processBookList($matches[1]);
        } else {
            RequestUtil::render404();
        }
    }

    private function processBookList(int $author_id): void
    {
        $books = $this->bookLogic->fetchAllBooksFromAuthor($author_id);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($books);
    }

    private function processBookCreate(int $author_id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = SinglePageBookController::validateFormInput($title, $year);

            if (empty($errors)) {
                $book = $this->bookLogic->createBook($title, $year, $author_id);
                if ($book === null) {
                    http_response_code(500);
                    echo json_encode(['error' => "Book insert failed!"]);
                } else {
                    http_response_code(200);
                    echo json_encode($book);
                }
            } else {
                $response = $errors;
                $response['title'] = $title;
                $response['year'] = $year;

                http_response_code(400);
                echo json_encode($response);
            }
        }
    }

    private function processBookEdit(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = SinglePageBookController::validateFormInput($title, $year);

            if (empty($errors)) {
                $book = $this->bookLogic->editBook($id, $title, $year);
                if ($book === null) {
                    http_response_code(500);
                    echo json_encode(['error' => "Book edit failed!"]);
                } else {
                    http_response_code(200);
                    echo json_encode($book);
                }
            } else {
                $response = $errors;
                $book = $this->bookLogic->fetchBook($id);
                $response['title'] = $book->getTitle();
                $response['year'] = $book->getYear();


                http_response_code(400);
                echo json_encode($response);
            }
        }
    }

    public function processBookDelete(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($this->bookLogic->deleteBook($id)) {
                http_response_code(200);
                echo json_encode("Deletion successful!");
            } else {
                http_response_code(400);
                echo json_encode("Deletion failed!");
            }
        }
    }

    private static function validateFormInput($title, $year): array
    {
        $errors = [];

        if (!Validator::validateNotEmpty($title)) {
            $errors['title_error'] = 'Title is required.';
        } else {
            $title = Validator::sanitizeData($title);
            if (!Validator::validateAlphanumeric($title)) {
                $errors['title_error'] = 'Title is not in a valid format.';
            }
        }

        if (!Validator::validateNotEmpty($year)) {
            $errors['year_error'] = 'Year is required.';
        } else {
            $year = Validator::sanitizeData($year);
            if (!Validator::validateNumber($year)) {
                $errors['year_error'] = 'Year is not in a valid format.';
            }
        }

        return $errors;
    }

}