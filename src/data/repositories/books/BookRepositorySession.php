<?php

namespace Bookstore\Data\Repository;

require_once __DIR__ . '/../../models/Book.php';
require_once __DIR__ . '/BookRepositoryInterface.php';

use Bookstore\Data\Model\Book;

class BookRepositorySession implements BookRepositoryInterface
{

    private const SESSION_TAG = "books";
    private const ID_TAG = "book_id";

    /**
     * Initialize session with book data.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public static function initializeData(): void
    {
        $book_repository_session = new BookRepositorySession();
        $book_repository_session->add(new Book("Book Name", 2001));
        $book_repository_session->add(new Book("Book Name 1", 2002));
        $book_repository_session->add(new Book("Book Name 2", 1997));
        $book_repository_session->add(new Book("Book Name 3", 2005));
        $book_repository_session->add(new Book("Book Name 4", 2006));
    }

    /**
     * Check if session has been initialized with book data.
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
     * Fetch all books.
     *
     * @return array Array of books.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function fetchAll(): array
    {
        return $_SESSION[BookRepositorySession::SESSION_TAG];
    }

    /**
     * Fetch a book.
     *
     * @param int $id Id of book to be fetched.
     * @return Book|null Book if found. Null otherwise.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function fetch(int $id): ?Book
    {
        return $_SESSION[BookRepositorySession::SESSION_TAG][$id];
    }

    /**
     * Add a book.
     *
     * @param Book $author Book to be added.
     * @return bool True if adding successful. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function add(Book $book): bool
    {
//        if (!isset($_SESSION[BookRepositorySession::SESSION_TAG][$book->getId()])) {
//            $_SESSION[BookRepositorySession::SESSION_TAG][$book->getId()] = $book;
//
//            return true;
//        }
        $book->setId(BookRepositorySession::generateId());
        $_SESSION[BookRepositorySession::SESSION_TAG][$book->getId()] = $book;

        return false;
    }

    /**
     * Edit a book.
     *
     * @param int $id Id of book to be edited.
     * @param string $title New title value.
     * @param int $year New year value.
     * @return bool True if editing successful. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function edit(int $id, string $title, int $year): bool
    {
        if (isset($_SESSION[BookRepositorySession::SESSION_TAG][$id])) {
            $_SESSION[BookRepositorySession::SESSION_TAG][$id]->setTitle($title);
            $_SESSION[BookRepositorySession::SESSION_TAG][$id]->setYear($year);

            return true;
        }

        return false;
    }

    /**
     * Delete a book.
     *
     * @param int $id Id of book to be deleted.
     * @return bool True if deletion successful. Otherwise, not.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
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
     * Remove multiple books.
     *
     * @param array $ids Ids of books to be removed.
     * @return bool True if deletion successful. Otherwise, not.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function deleteMultiple(array $ids): bool
    {
        $deleted_count = 0;

        foreach ($ids as $book_id) {
            if (isset($_SESSION[BookRepositorySession::SESSION_TAG][$book_id])) {
                unset($_SESSION[BookRepositorySession::SESSION_TAG][$book_id]);
                $deleted_count++;
            }
        }

        if ($deleted_count == count($ids)) {
            return true;
        }

        return false;
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