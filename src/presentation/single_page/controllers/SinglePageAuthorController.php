<?php

namespace Logeecom\Bookstore\presentation\single_page\controllers;

use Logeecom\Bookstore\business\logic\AuthorLogic;
use Logeecom\Bookstore\presentation\multi_page\controllers\MultiPageAuthorController;
use Logeecom\Bookstore\presentation\util\RequestUtil;
use Logeecom\Bookstore\presentation\util\Validator;

class SinglePageAuthorController implements \Logeecom\Bookstore\presentation\interfaces\ControllerInterface
{

    private const REQUEST_CREATE = '/^\/spa\/authors\/create\/?$/';
    private const REQUEST_EDIT = '/^\/spa\/authors\/edit\/(\d+)\/?$/';
    private const REQUEST_DELETE = '/^\/spa\/authors\/delete\/(\d+)\/?$/';
    private const REQUEST_LIST = '/^\/spa(?:\/authors\/?)?$/';

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
        } else {
            RequestUtil::render404();
        }
    }

    private function processAuthorList()
    {
        $authors_with_book_count = $this->authorLogic->fetchAllAuthorsWithBookCount();


        include($_SERVER['DOCUMENT_ROOT'] . "/src/presentation/multi_page/views/authors/author_list.php");
    }

    private function processAuthorCreate()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            $errors = SinglePageAuthorController::validateFormInput($first_name, $last_name);

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

    private function processAuthorEdit(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            $errors = SinglePageAuthorController::validateFormInput(
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

    private function processAuthorDelete(int $id)
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

    private function validateFormInput($first_name, $last_name): ?array
    {
        $first_name_error = "";
        $last_name_error = "";

        if (!Validator::validateNotEmpty($first_name)) {
            $first_name_error = "First name is required.";
        } else {
            $first_name = Validator::sanitizeData($first_name);
            if (!Validator::validateAlphabetical($first_name)) {
                $first_name_error = "First name is not in a valid format.";
            }
        }

        if (!Validator::validateNotEmpty($last_name)) {
            $last_name_error = "Last name is required.";
        } else {
            $last_name = Validator::sanitizeData($last_name);
            if (!Validator::validateAlphabetical($last_name)) {
                $last_name_error = "Last name is not in a valid format.";
            }
        }

        if (!($first_name_error == "" && $last_name_error == "")) {
            return [
                "first_name_error" => $first_name_error,
                "last_name_error" => $last_name_error
            ];
        }

        return null;
    }

}