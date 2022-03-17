<?php

namespace Bookstore\Data\Repository;

require_once __DIR__ . "/../../models/Author.php";
require_once __DIR__ . '/AuthorRepositoryInterface.php';

use Bookstore\Data\Model\Author;

class AuthorRepositorySession implements AuthorRepositoryInterface
{

    private const SESSION_TAG = "authors";
    private const ID_TAG = "author_id";

    /**
     * Initialize session with author data.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public static function initializeData(): void
    {
        $author_repository_session = new AuthorRepositorySession();
        $author_repository_session->add(new Author("Pera", "Peric", [0 => 0, 4 => 4]));
        $author_repository_session->add(new Author("Mika", "Mikic", [1 => 1]));
        $author_repository_session->add(new Author("Zika", "Zikic", [2 => 2]));
        $author_repository_session->add(new Author("Nikola", "Nikolic", [3 => 3]));
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
//        if (!isset($_SESSION[AuthorRepositorySession::SESSION_TAG][$author->getId()])) {
//            $_SESSION[AuthorRepositorySession::SESSION_TAG][$author->getId()] = $author;
//
//            return true;
//        }
        $author->setId(AuthorRepositorySession::generateId());
        $_SESSION[AuthorRepositorySession::SESSION_TAG][$author->getId()] = $author;

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
     * @param int $id Id of book to be removed.
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

    /**
     * Generates next unique id for Author.
     *
     * @return int Newly generated unique Author id.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private static function generateId(): int
    {
        if (!isset($_SESSION[AuthorRepositorySession::ID_TAG])) {
            $_SESSION[AuthorRepositorySession::ID_TAG] = 1;
            return 0;
        } else {
            return $_SESSION[AuthorRepositorySession::ID_TAG]++;
        }
    }

}