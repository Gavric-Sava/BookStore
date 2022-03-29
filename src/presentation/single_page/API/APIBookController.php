<?php

namespace Logeecom\Bookstore\presentation\single_page\API;

use Logeecom\Bookstore\business\logic\books\BookLogic;
use Logeecom\Bookstore\presentation\base_controllers\BaseBookController;

class APIBookController extends BaseBookController
{

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
     * Fetches list of books and returns it as JSON.
     *
     * @param int $author_id - Id of author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function processBookList(int $author_id): void
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
    public function processBookCreate(int $author_id): void
    {
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

    /**
     * Tries to edit book. Returns edited book or errors as JSON.
     *
     * @param int $id Id of the book to be edited.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processBookEdit(int $id): void
    {
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

    /**
     * Tries to delete book. Returns 200 on success and 500 on failure.
     *
     * @param int $id Id of the book to be deleted.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processBookDelete(int $id): void
    {
        if ($this->bookLogic->deleteBook($id)) {
            http_response_code(200);
            echo json_encode("Deletion successful!");
        } else {
            http_response_code(400);
            echo json_encode("Deletion failed!");
        }
    }

}