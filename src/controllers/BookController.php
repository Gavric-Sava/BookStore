<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../data/repositories/BookSessionRepository.php';
require_once './src/util/RequestUtil.php';

class BookController extends BaseController
{

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
        $books = BookSessionRepository::fetchAll();
        require($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_list.php");
    }

    private function processBookCreate(): void
    {
        $title_error = "";
        $year_error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            // TODO validate
            if (BookController::validateFormInput(
                $title,
                $title_error,
                $year,
                $year_error)) {
                BookSessionRepository::add(new Book($title, $year));
                header('Location: http://bookstore.test/books');
            } else {
                require($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_create.php");
            }
        } else {
            require($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_create.php");
        }
    }

    private function processBookEdit($id): void
    {
        $title_error = "";
        $year_error = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            // TODO validate
            if (BookController::validateFormInput(
                $title,
                $title_error,
                $year,
                $year_error)) {
                BookSessionRepository::edit($id, $title, $year);
                header('Location: http://bookstore.test/books');
            } else {
                $book = BookSessionRepository::fetch($id);
                require($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_edit.php");
            }
        } else {
            $book = BookSessionRepository::fetch($id);
            require($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_edit.php");
        }
    }

    private function processBookDelete($id)
    {
        $book = BookSessionRepository::fetch($id);
        if (!isset($book)) {
            RequestUtil::render404();
        } else {
            require($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_delete.php");
        }
    }

    private static function validateFormInput($title, &$title_error, $year, &$year_error): bool
    {
        if (!RequestUtil::validateNotEmpty($title)) {
            $title_error = "Title is required.";
        } else {
            $title = RequestUtil::cleanData($title);
            if (!RequestUtil::validateAlphabetical($title)) {
                $title_error = "Title is not in a valid format.";
            }
        }

        if (!RequestUtil::validateNotEmpty($year)) {
            $year_error = "Year is required.";
        } else {
            $year = RequestUtil::cleanData($year);
            if (!RequestUtil::validateNumber($year)) {
                $year_error = "Year is not in a valid format.";
            }
        }

        return ($title_error == "" && $year_error == "");
    }

}