<?php

namespace Logeecom\Bookstore\presentation\single_page\backend\controllers;

use Logeecom\Bookstore\business\logic\books\BookLogic;
use Logeecom\Bookstore\presentation\interfaces\BaseBookController;
use Logeecom\Bookstore\presentation\util\RequestUtil;

class SinglePageBookController extends BaseBookController
{
    /**
     * Regex for create request path.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private const REQUEST_CREATE = '/^\/spa\/authors\/(\d*)\/books\/create\/?$/';
    /**
     * Regex for edit request path.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private const REQUEST_EDIT = '/^\/spa\/authors\/(\d*)\/books\/edit\/(\d+)\/?$/';
    /**
     * Regex for delete request path.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private const REQUEST_DELETE = '/^\/spa\/authors\/(\d*)\/books\/delete\/(\d+)\/?$/';
    /**
     * Regex for list request path.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private const REQUEST_LIST = '/^\/spa\/authors\/(\d*)\/(?:books)?\/?$/';

    /**
     * @var BookLogic - Author business logic.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private BookLogic $bookLogic;

    public function __construct(
        BookLogic $bookLogic
    ) {
        $this->bookLogic = $bookLogic;
    }

    /**
     * @inheritDoc
     */
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

    /**
     * Fetches list of books and returns it as JSON.
     *
     * @param int $author_id - Id of author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    protected function processBookList(int $author_id): void
    {
        $books = $this->bookLogic->fetchAllBooksFromAuthor($author_id);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($books);
    }

    /**
     * Tries to create new book. Returns new book or errors as JSON.
     *
     * @param int $author_id - Id of author of the book.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    protected function processBookCreate(int $author_id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = $this->validateFormInput($title, $year);

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

    /**
     * Tries to edit book. Returns edited book or errors as JSON.
     *
     * @param int $id Id of the book to be edited.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected function processBookEdit(int $id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST["title"];
            $year = $_POST["year"];

            $errors = $this->validateFormInput($title, $year);

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

    /**
     * Tries to delete book. Returns 200 on success and 500 on failure.
     *
     * @param int $id Id of the book to be deleted.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected function processBookDelete(int $id): void
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

}