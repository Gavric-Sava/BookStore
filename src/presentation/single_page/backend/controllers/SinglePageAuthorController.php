<?php

namespace Logeecom\Bookstore\presentation\single_page\backend\controllers;

use Logeecom\Bookstore\business\logic\AuthorLogic;
use Logeecom\Bookstore\presentation\interfaces\ControllerInterface;
use Logeecom\Bookstore\presentation\util\RequestUtil;
use Logeecom\Bookstore\presentation\util\Validator;

class SinglePageAuthorController implements ControllerInterface
{

    private const REQUEST_CREATE = '/^\/spa\/authors\/create\/?$/';
    private const REQUEST_EDIT = '/^\/spa\/authors\/edit\/(\d+)\/?$/';
    private const REQUEST_DELETE = '/^\/spa\/authors\/delete\/(\d+)\/?$/';
    private const REQUEST_LIST = '/^\/spa\/authors\/?$/';
    private const REQUEST_INDEX = '/^\/spa\/?$/';

    private AuthorLogic $authorLogic;

    public function __construct(
        AuthorLogic $authorLogic
    ) {
        $this->authorLogic = $authorLogic;
    }

    public function process(string $path): void
    {
        if (preg_match(SinglePageAuthorController::REQUEST_CREATE, $path)) {
            $this->processAuthorCreate();
        } elseif (preg_match(SinglePageAuthorController::REQUEST_EDIT, $path, $matches)) {
            $this->processAuthorEdit($matches[1]);
        } elseif (preg_match(SinglePageAuthorController::REQUEST_DELETE, $path, $matches)) {
            $this->processAuthorDelete($matches[1]);
        } elseif (preg_match(SinglePageAuthorController::REQUEST_LIST, $path)) {
            $this->processAuthorList();
        } elseif (preg_match(SinglePageAuthorController::REQUEST_INDEX, $path)) {
            $this->processIndex();
        } else {
            RequestUtil::render404();
        }
    }

    private function processIndex()
    {
//        $authors_with_book_count = $this->authorLogic->fetchAllAuthorsWithBookCount();
//
//        include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/authors/author_list.php");
        include ($_SERVER['DOCUMENT_ROOT']) . "/src/presentation/single_page/frontend/index.html";

    }

    private function processAuthorList()
    {
        $authors_with_book_count = $this->authorLogic->fetchAllAuthorsWithBookCount();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($authors_with_book_count);
    }

    private function processAuthorCreate()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            $errors = SinglePageAuthorController::validateFormInput($first_name, $last_name);

            if (empty($errors)) {
                $this->authorLogic->createAuthor($first_name, $last_name);
                http_response_code(200);
                // TODO echo $author;
            } else {
                $response = $errors;
                $response['first_name'] = $first_name;
                $response['last_name'] = $last_name;

                // TODO return 400 and errors;
                http_response_code(400);
                echo json_encode($response);
            }
        }
    }

    private function processAuthorEdit(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            $errors = SinglePageAuthorController::validateFormInput($first_name, $last_name);

            if (empty($errors)) {
                $this->authorLogic->editAuthor($id, $first_name, $last_name);
                http_response_code(200);
                // TODO echo $author;
            } else {
                $response = $errors;

                $author = $this->authorLogic->fetchAuthor($id);
                $response['first_name'] = $author->getFirstname();
                $response['last_name'] = $author->getLastname();

                // TODO return 400 and errors;
                http_response_code(400);
                echo json_encode($response);
            }
        }
    }

    private function processAuthorDelete(int $id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($this->authorLogic->deleteAuthor($id)) {
                http_response_code(200);
                echo json_encode("Deletion successful!");
            } else {
                http_response_code(400);
                echo json_encode("Deletion failed!");
            }
        }
    }

    private function validateFormInput($first_name, $last_name): array
    {
        $errors = [];

        if (!Validator::validateNotEmpty($first_name)) {
            $errors["first_name_error"] = 'First name is required.';
        } else {
            $first_name = Validator::sanitizeData($first_name);
            if (!Validator::validateAlphabetical($first_name)) {
                $errors["first_name_error"] = 'First name is not in a valid format.';
            }
        }

        if (!Validator::validateNotEmpty($last_name)) {
            $errors["last_name_error"] = 'Last name is required.';
        } else {
            $last_name = Validator::sanitizeData($last_name);
            if (!Validator::validateAlphabetical($last_name)) {
                $errors["last_name_error"] = 'Last name is not in a valid format.';
            }
        }

        return $errors;
    }

}