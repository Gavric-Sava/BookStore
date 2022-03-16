<?php

namespace Bookstore\Data\Repository;

require_once __DIR__ . "/../../models/Author.php";
require_once __DIR__ . '/AuthorRepositoryInterface.php';

use Bookstore\Data\Model\Author;

class AuthorRepositorySession implements AuthorRepositoryInterface
{

    public const SESSION_TAG = "authors";

    /**
     * Initialize session with author data.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public static function initializeData(): void
    {
        $_SESSION[AuthorRepositorySession::SESSION_TAG] = [
            0 => (new Author("Pera", "Peric", [0 => 0, 4 => 4])),
            1 => (new Author("Mika", "Mikic", [1 => 1])),
            2 => (new Author("Zika", "Zikic", [2 => 2])),
            3 => (new Author("Nikola", "Nikolic", [3 => 3]))
        ];
    }

    /**
     * Check if session has been initialized with author data.
     *
     * @return bool True if session already initialized. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public static function dataInitialized(): bool
    {
        return isset($_SESSION[AuthorRepositorySession::SESSION_TAG]);
    }

    /**
     * Fetch all authors.
     *
     * @return array Array of authors.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function fetchAll(): array
    {
        return $_SESSION[AuthorRepositorySession::SESSION_TAG];
    }

    /**
     * Fetch an author.
     *
     * @param int $id Id of author to be fetched.
     * @return Author|null Author if found. Null otherwise.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function fetch(int $id): ?Author
    {
        return $_SESSION[AuthorRepositorySession::SESSION_TAG][$id];
    }

    /**
     * Add an author.
     *
     * @param Author $author Author to be added.
     * @return bool True if adding successful. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function add(Author $author): bool
    {
        if (!isset($_SESSION[AuthorRepositorySession::SESSION_TAG][$author->getId()])) {
            $_SESSION[AuthorRepositorySession::SESSION_TAG][$author->getId()] = $author;

            return true;
        }

        return false;
    }

    /**
     * Edit an author.
     *
     * @param int $id Id of author to be edited.
     * @param string $first_name New firstname value.
     * @param string $last_name New lastname value.
     * @return bool True if editing successful. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function edit(int $id, string $first_name, string $last_name): bool
    {
        if (isset($_SESSION[AuthorRepositorySession::SESSION_TAG][$id])) {
            $_SESSION[AuthorRepositorySession::SESSION_TAG][$id]->setFirstname($first_name);
            $_SESSION[AuthorRepositorySession::SESSION_TAG][$id]->setLastname($last_name);

            return true;
        }

        return false;
    }

    /**
     * Delete an author.
     *
     * @param int $id Id of author to be deleted.
     * @return bool True if deletion successful. Otherwise, not.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function delete(int $id): bool
    {
        if (isset($_SESSION[AuthorRepositorySession::SESSION_TAG][$id])) {
            unset($_SESSION[AuthorRepositorySession::SESSION_TAG][$id]);

            return true;
        }

        return false;
    }

    /**
     * Remove book from corresponding author.
     *
     * @param int $book_id Id of book to be removed.
     * @return bool True if deletion successful. Otherwise, not.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function deleteBook(int $id): bool
    {
        foreach ($_SESSION[AuthorRepositorySession::SESSION_TAG] as $author) {
            if (in_array($id, $author->getBooks())) {
                $author->deleteBook($id);

                return true;
            }
        }

        return false;
    }

}