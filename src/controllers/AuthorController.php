<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../data/repositories/authors/AuthorRepositoryInterface.php';
require_once __DIR__ . '/../data/repositories/books/BookRepositoryInterface.php';
require_once './src/util/RequestUtil.php';

class AuthorController extends BaseController
{

    private AuthorRepositoryInterface $authorRepository;
    private BookRepositoryInterface $bookRepository;

    public function __construct(
        AuthorRepositoryInterface $authorRepository,
        BookRepositoryInterface $bookRepository
    ) {
        $this->authorRepository = $authorRepository;
        $this->bookRepository = $bookRepository;
    }

    public function process(string $path)
    {
        if (preg_match('/^\/authors\/create\/?$/', $path)) {
            $this->processAuthorCreate();
        } elseif (preg_match('/^\/authors\/edit\/(\d+)\/?$/', $path, $matches)) {
            $this->processAuthorEdit($matches[1]);
        } elseif (preg_match('/^\/authors\/delete\/(\d+)\/?$/', $path, $matches)) {
            $this->processAuthorDelete($matches[1]);
        } elseif (preg_match('/^\/(?:authors\/?)?$/', $path)) {
            $this->processAuthorList();
        } else {
            RequestUtil::render404();
        }
    }

    private function processAuthorList(): void
    {
        $authors = $this->authorRepository->fetchAll();
        require($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_list.php");
    }

    private function processAuthorCreate(): void
    {
        $first_name_error = "";
        $last_name_error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            if (AuthorController::validateFormInput(
                $first_name,
                $first_name_error,
                $last_name,
                $last_name_error
            )) {
                $this->authorRepository->add(new Author($first_name, $last_name));
                header('Location: http://bookstore.test');
            } else {
                require($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_create.php");
            }
        } else {
            require($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_create.php");
        }
    }

    private function processAuthorEdit($id): void
    {
        $first_name_error = "";
        $last_name_error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            if (AuthorController::validateFormInput(
                $first_name,
                $first_name_error,
                $last_name,
                $last_name_error
            )) {
                $this->authorRepository->edit($id, $first_name, $last_name);
                header('Location: http://bookstore.test');
            } else {
                $author = $this->authorRepository->fetch($id);
                require($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_edit.php");
            }
        } else {
            $author = $this->authorRepository->fetch($id);
            if (!isset($author)) {
                RequestUtil::render404();
            } else {
                require($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_edit.php");
            }
        }
    }

    private function processAuthorDelete($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $books = $this->authorRepository->fetch($id)->getBooks();
            if ($this->authorRepository->delete($id)) {
                $this->bookRepository->deleteMultiple($books);
            }

            header('Location: http://bookstore.test');
        } else {
            $author = $this->authorRepository->fetch($id);
            if (!isset($author)) {
                RequestUtil::render404();
            } else {
                require($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_delete.php");
            }
        }
    }

    private static function validateFormInput($first_name, &$first_name_error, $last_name, &$last_name_error): bool
    {
        if (!RequestUtil::validateNotEmpty($first_name)) {
            $first_name_error = "First name is required.";
        } else {
            $first_name = RequestUtil::cleanData($first_name);
            if (!RequestUtil::validateAlphabetical($first_name)) {
                $first_name_error = "First name is not in a valid format.";
            }
        }

        if (!RequestUtil::validateNotEmpty($last_name)) {
            $last_name_error = "Last name is required.";
        } else {
            $last_name = RequestUtil::cleanData($last_name);
            if (!RequestUtil::validateAlphabetical($last_name)) {
                $last_name_error = "Last name is not in a valid format.";
            }
        }

        return ($first_name_error == "" && $last_name_error == "");
    }

}