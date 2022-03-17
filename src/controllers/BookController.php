<?php

namespace Bookstore\Controller;

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../data/repositories/authors/AuthorRepositoryInterface.php';
require_once __DIR__ . '/../data/repositories/books/BookRepositoryInterface.php';
require_once './src/util/RequestUtil.php';

use Bookstore\Data\Model\Book;
use Bookstore\Data\Repository\{AuthorRepositoryInterface, BookRepositoryInterface};
use Bookstore\Util\RequestUtil;

class BookController extends BaseController
{

    /**
     * @var AuthorRepositoryInterface Interface towards Author repository.
     *
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private AuthorRepositoryInterface $authorRepository;
    /**
     * @var BookRepositoryInterface Interface towards Book repository.
     *
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private BookRepositoryInterface $bookRepository;

    public function __construct(
        AuthorRepositoryInterface $authorRepository,
        BookRepositoryInterface $bookRepository
    ) {
        $this->authorRepository = $authorRepository;
        $this->bookRepository = $bookRepository;
    }

    public function process(string $path): void
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

    /**
     * Implementation of the 'Book list' use case.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private function processBookList(): void
    {
        $books = $this->bookRepository->fetchAll();
        include($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_list.php");
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
            if ($this->bookRepository->delete($id)) {
                $this->authorRepository->deleteBook($id);
            }

            header('Location: http://bookstore.test/books');
        } else {
            $book = $this->bookRepository->fetch($id);
            if (!isset($book)) {
                RequestUtil::render404();
            } else {
                include($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_delete.php");
            }
        }
    }

    /**
     * Validation of input form data for 'Book create' and 'Book edit' use cases.
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