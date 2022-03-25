<?php

namespace Logeecom\Bookstore\presentation\single_page\backend\controllers;

use Logeecom\Bookstore\business\logic\AuthorLogic;
use Logeecom\Bookstore\presentation\interfaces\BaseAuthorController;
use Logeecom\Bookstore\presentation\util\RequestUtil;

class SinglePageAuthorController extends BaseAuthorController
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
        include ($_SERVER['DOCUMENT_ROOT']) . "/src/presentation/single_page/frontend/index.php";
    }

    protected function processAuthorList(): void
    {
        $authors_with_book_count = $this->authorLogic->fetchAllAuthorsWithBookCount();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($authors_with_book_count);
    }

    protected function processAuthorCreate(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            $errors = $this->validateFormInput($first_name, $last_name);

            if (empty($errors)) {
                $author = $this->authorLogic->createAuthor($first_name, $last_name);
                if ($author === null) {
                    http_response_code(500);
                    echo json_encode(['error' => "Author insert failed!"]);
                } else {
                    http_response_code(200);
                    echo json_encode($author);
                }

            } else {
                $response = $errors;
                $response['first_name'] = $first_name;
                $response['last_name'] = $last_name;

                http_response_code(400);
                echo json_encode($response);
            }
        }
    }

    protected function processAuthorEdit(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            $errors = $this->validateFormInput($first_name, $last_name);

            if (empty($errors)) {
                $author = $this->authorLogic->editAuthor($id, $first_name, $last_name);
                if ($author === null) {
                    http_response_code(500);
                    echo json_encode(['error' => "Author edit failed!"]);
                } else {
                    http_response_code(200);
                    echo json_encode($author);
                }
            } else {
                $response = $errors;

                $author = $this->authorLogic->fetchAuthor($id);
                $response['first_name'] = $author->getFirstname();
                $response['last_name'] = $author->getLastname();

                http_response_code(400);
                echo json_encode($response);
            }
        }
    }

    protected function processAuthorDelete(int $id): void
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

}