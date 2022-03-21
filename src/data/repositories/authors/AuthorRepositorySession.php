<?php

namespace Logeecom\Bookstore\data\repositories\authors;

use Logeecom\Bookstore\data\models\Author;
use Logeecom\Bookstore\data\repositories\books\BookRepositorySession;

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
        $author_repository_session->add(new Author("Pera", "Peric", 2));
        $author_repository_session->add(new Author("Mika", "Mikic", 1));
        $author_repository_session->add(new Author("Zika", "Zikic", 1));
        $author_repository_session->add(new Author("Nikola", "Nikolic", 1));
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
     * @inheritDoc
     */
    public function fetchAll(): array
    {
        return $_SESSION[AuthorRepositorySession::SESSION_TAG];
    }

    /**
     * @inheritDoc
     */
    public function fetch(int $id): ?Author
    {
        return $_SESSION[AuthorRepositorySession::SESSION_TAG][$id];
    }

    /**
     * @inheritDoc
     */
    public function add(Author $author): bool
    {
        $author->setId(AuthorRepositorySession::generateId());
        $_SESSION[AuthorRepositorySession::SESSION_TAG][$author->getId()] = $author;

        return false;
    }

    /**
     * @inheritDoc
     */
    public function edit(int $id, string $firstname, string $lastname): bool
    {
        if (isset($_SESSION[AuthorRepositorySession::SESSION_TAG][$id])) {
            $_SESSION[AuthorRepositorySession::SESSION_TAG][$id]->setFirstname($firstname);
            $_SESSION[AuthorRepositorySession::SESSION_TAG][$id]->setLastname($lastname);

            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        if (isset($_SESSION[AuthorRepositorySession::SESSION_TAG][$id])) {
            if ((new BookRepositorySession())->deleteAllFromAuthor($id)) {
                unset($_SESSION[AuthorRepositorySession::SESSION_TAG][$id]);
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

    /**
     * @inheritDoc
     */
    public function fetchAllWithBookCount(): array
    {
        $authors_with_book_counts = [];
        $book_repository_session = new BookRepositorySession();

        $authors = $this->fetchAll();
        foreach ($authors as $author) {
            array_push($authors_with_book_counts, [
                "author" => $author,
                "book_count" => $book_repository_session->countFromAuthor($author->getId())
            ]);
        }

        return $authors_with_book_counts;
    }


}