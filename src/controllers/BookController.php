<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../data/repositories/authors/AuthorRepositoryInterface.php';
require_once __DIR__ . '/../data/repositories/books/BookRepositoryInterface.php';
require_once './src/util/RequestUtil.php';

class BookController extends BaseController
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
        if (preg_match('/^\/books\/create\/?$/', $path)) {
            $this->processBookCreate();
        } elseif (preg_match('/^\/books\/edit\/(\d+)\/?$/', $path, $matches)) {
            $this->processBookEdit($matches[1]);
        } elseif (preg_match('/^\/books\/delete\/(\d+)\/?$/', $path, $matches)) {
            $this->processBookDelete($matches[1]);
        } elseif (preg_match('/^\/books\/?$/', $path)) {
            $this->processBookList();
        } else {
            RequestUtil::render404();
        }
    }

    private function processBookList(): void
    {
        $books = $this->bookRepository->fetchAll();
        require($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_list.php");
    }

    private function processBookCreate(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = BookController::validateFormInput($title, $year);

            if (empty($errors)) {
                $this->bookRepository->add(new Book($title, $year));
                header('Location: http://bookstore.test/books');
            } else {
                $title_error = $errors["title_error"];
                $year_error = $errors["year_error"];

                include($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_create.php");
            }
        } else {
            include($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_create.php");
        }
    }

    private function processBookEdit($id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = BookController::validateFormInput($title, $year);

            if (empty($errors)) {
                $this->bookRepository->edit($id, $title, $year);
                header('Location: http://bookstore.test/books');
            } else {
                $title_error = $errors["title_error"];
                $year_error = $errors["year_error"];

                $book = $this->bookRepository->fetch($id);
                include($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_edit.php");
            }
        } else {
            $book = $this->bookRepository->fetch($id);
            include($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_edit.php");
        }
    }

    public function processBookDelete($id): void
    {
        if ($this->bookRepository->delete($id)) {
            $this->authorRepository->deleteBook($id);
        }

        header('Location: http://bookstore.test/books');
    }

    private static function validateFormInput($title, $year): ?array
    {
        $title_error = "";
        $year_error = "";

        if (!RequestUtil::validateNotEmpty($title)) {
            $title_error = "Title is required.";
        } else {
            $title = RequestUtil::sanitizeData($title);
            if (!RequestUtil::validateAlphanumeric($title)) {
                $title_error = "Title is not in a valid format.";
            }
        }

        if (!RequestUtil::validateNotEmpty($year)) {
            $year_error = "Year is required.";
        } else {
            $year = RequestUtil::sanitizeData($year);
            if (!RequestUtil::validateNumber($year)) {
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