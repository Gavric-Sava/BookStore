<?php

namespace Logeecom\Bookstore\presentation\multi_page\controllers;

use Logeecom\Bookstore\business\logic\interfaces\BookLogicInterface;
use Logeecom\Bookstore\presentation\base_controllers\BaseBookController;
use Logeecom\Bookstore\presentation\multi_page\views\ViewTemplate;
use Logeecom\Bookstore\presentation\util\RequestUtil;

class MultiPageBookController extends BaseBookController
{
    /**
     * @var BookLogicInterface - Book business logic.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private BookLogicInterface $bookLogic;
    private ViewTemplate $viewTemplate;

    public function __construct(
        BookLogicInterface $bookLogic,
        ViewTemplate $viewTemplate
    ) {
        $this->bookLogic = $bookLogic;
        $this->viewTemplate = $viewTemplate;
    }

    /**
     * Renders list of books.
     *
     * @param int $author_id - Id of author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function renderBookList(int $author_id): void
    {
        $books = $this->bookLogic->fetchAllBooksFromAuthor($author_id);

        echo $this->viewTemplate->render(
            'template.php',
            [
                'head' => ($this->viewTemplate->render('books/partials/book_list_head.html')),
                'content' => ($this->viewTemplate->render(
                    'books/templates/book_list.php',
                    [
                        'books' => $books,
                        'author_id' => $author_id
                    ]
                ))
            ]
        );
    }

    /**
     * Returns book list view.
     *
     * @param int $author_id - Id of author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processBookList(int $author_id): void
    {
        $this->renderBookList($author_id);
    }

    /**
     * Renders book create form.
     *
     * @param int $author_id - Id of author.
     * @param array $errors - Form input errors.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function renderBookCreate(int $author_id, array $errors = []): void
    {
        echo $this->viewTemplate->render(
            'template.php',
            [
                'head' => ($this->viewTemplate->render('books/partials/book_create_head.html')),
                'content' => ($this->viewTemplate->render(
                    'books/templates/book_form.php',
                    array_merge(['function_label' => 'Create'], $errors)
                ))
            ]
        );
    }

    /**
     * Returns book create form view. On error returns form view with errors.
     *
     * @param int $author_id - Id of author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function processBookCreate(int $author_id): void
    {
        $title = $_POST["title"];
        $year = $_POST["year"];

        $errors = $this->validateFormInput($title, $year);

        if (empty($errors)) {
            $this->bookLogic->createBook($title, $year, $author_id);
            header(
                'Location: ' .
                $_SERVER['REQUEST_SCHEME'] .
                '://' . $_SERVER['HTTP_HOST'] .
                "/authors/{$author_id}/books"
            );
        } else {
            $this->renderBookCreate($author_id, $errors);
        }
    }

    /**
     * Renders book edit form.
     *
     * @param int $id - Id of book.
     * @param array $errors - Form input errors.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function renderBookEdit(int $id, array $errors = []): void
    {
        $book = $this->bookLogic->fetchBook($id);
        if (!isset($book)) {
            RequestUtil::render404();
        } else {
            echo $this->viewTemplate->render(
                'template.php',
                [
                    'head' => ($this->viewTemplate->render('books/partials/book_edit_head.html')),
                    'content' => ($this->viewTemplate->render(
                        'books/templates/book_form.php',
                        array_merge(
                            [
                                'function_label' => 'Edit',
                                'book' => $book
                            ],
                            $errors
                        )
                    ))
                ]
            );
        }
    }

    /**
     * Returns book edit form view. On error returns form view with errors.
     *
     * @param int $id - Id of the book to be edited.
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
            $this->bookLogic->editBook($id, $title, $year);
            $book = $this->bookLogic->fetchBook($id);

            header(
                'Location: ' . $_SERVER['REQUEST_SCHEME'] .
                '://' .
                $_SERVER['HTTP_HOST'] .
                "/authors/{$book->getAuthorId()}/books"
            );
        } else {
            $this->renderBookEdit($id, $errors);
        }
    }

    /**
     * Renders book delete dialog.
     *
     * @param int $id - Id of book.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function renderBookDelete(int $id): void
    {
        $book = $this->bookLogic->fetchBook($id);
        if (!isset($book)) {
            RequestUtil::render404();
        } else {
            echo $this->viewTemplate->render(
                'template.php',
                [
                    'head' => ($this->viewTemplate->render('books/partials/book_delete_head.html')),
                    'content' => ($this->viewTemplate->render(
                        'books/templates/book_delete.php',
                        ['book' => $book]
                    ))
                ]
            );
        }
    }

    /**
     * Returns book delete dialog view. On error returns 404 view.
     *
     * @param int $id Id of book.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processBookDelete(int $id): void
    {
        $book = $this->bookLogic->fetchBook($id);
        $this->bookLogic->deleteBook($id);

        header(
            'Location: ' .
            $_SERVER['REQUEST_SCHEME'] .
            '://' .
            $_SERVER['HTTP_HOST'] .
            "/authors/{$book->getAuthorId()}/books"
        );
    }

}