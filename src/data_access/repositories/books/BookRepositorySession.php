<?php

namespace Logeecom\Bookstore\data_access\repositories\books;

use Logeecom\Bookstore\data_access\models\Book;

class BookRepositorySession implements BookRepositoryInterface
{

    private const SESSION_TAG = "books";
    private const ID_TAG = "book_id";

    /**
     * Initialize session with book data_access.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public static function initializeData(): void
    {
        $book_repository_session = new BookRepositorySession();
        $book_repository_session->add(new Book("Book Name", 2001, 0, 0));
        $book_repository_session->add(new Book("Book Name 1", 2002, 1, 1));
        $book_repository_session->add(new Book("Book Name 2", 1997, 2, 2));
        $book_repository_session->add(new Book("Book Name 3", 2005, 3, 3));
        $book_repository_session->add(new Book("Book Name 4", 2006, 0, 4));
    }

    /**
     * Check if session has been initialized with book data_access.
     *
     * @return bool True if session already initialized. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public static function dataInitialized(): bool
    {
        return isset($_SESSION[BookRepositorySession::SESSION_TAG]);
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(): array
    {
        return $_SESSION[BookRepositorySession::SESSION_TAG];
    }

    public function fetchAllFromAuthor(int $author_id): array {
        $books = [];

        foreach ($_SESSION[BookRepositorySession::SESSION_TAG] as $book) {
            if ($book->getAuthorId() === $author_id) {
                $books[] = $book;
            }
        }

        return $books;
    }

    /**
     * @inheritDoc
     */
    public function fetch(int $id): ?Book
    {
        return $_SESSION[BookRepositorySession::SESSION_TAG][$id];
    }

    /**
     * @inheritDoc
     */
    public function add(Book $book): bool
    {
        $book->setId(BookRepositorySession::generateId());
        $_SESSION[BookRepositorySession::SESSION_TAG][$book->getId()] = $book;

        return false;
    }

    /**
     * @inheritDoc
     */
    public function edit(int $id, string $title, int $year, ?int $author_id): bool
    {
        if (isset($_SESSION[BookRepositorySession::SESSION_TAG][$id])) {
            $_SESSION[BookRepositorySession::SESSION_TAG][$id]->setTitle($title);
            $_SESSION[BookRepositorySession::SESSION_TAG][$id]->setYear($year);
            $_SESSION[BookRepositorySession::SESSION_TAG][$id]->setAuthorId($author_id);

            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        if (isset($_SESSION[BookRepositorySession::SESSION_TAG][$id])) {
            unset($_SESSION[BookRepositorySession::SESSION_TAG][$id]);

            return true;
        }

        return false;
    }

    /**
     * Deletes all books from given author.
     * @param int $author_id Id of author.
     * @return bool Returns true if all books successfully deleted. Otherwise, returns false.
     */
    public function deleteAllFromAuthor(int $author_id): bool
    {
        foreach ($_SESSION[BookRepositorySession::SESSION_TAG] as $key => $value) {
            if ($_SESSION[BookRepositorySession::SESSION_TAG][$key]->getAuthorId() === $author_id) {
                unset($_SESSION[BookRepositorySession::SESSION_TAG][$key]);
            }
        }

        return true;
    }

    /**
     * Returns number of books written by the author.
     * @param int $id Id of the author.
     * @return int Number of books.
     */
    public function countFromAuthor(int $id): int
    {
        $count = 0;
        foreach ($_SESSION[BookRepositorySession::SESSION_TAG] as $book) {
            if ($book->getAuthorId() === $id) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Generates next unique id for Book.
     *
     * @return int Newly generated unique Book id.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private static function generateId(): int
    {
        if (!isset($_SESSION[BookRepositorySession::ID_TAG])) {
            $_SESSION[BookRepositorySession::ID_TAG] = 1;
            return 0;
        } else {
            return $_SESSION[BookRepositorySession::ID_TAG]++;
        }
    }

}