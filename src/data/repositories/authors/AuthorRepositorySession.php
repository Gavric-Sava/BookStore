<?php

require_once __DIR__ . "/../../models/Author.php";
require_once __DIR__ . '/AuthorRepositoryInterface.php';

class AuthorRepositorySession implements \AuthorRepositoryInterface
{

    public const SESSION_TAG = "authors";

    public static function initializeData(): void
    {
        $_SESSION[AuthorRepositorySession::SESSION_TAG] = [
            0 => (new Author("Pera", "Peric", [0 => 0, 4 => 4])),
            1 => (new Author("Mika", "Mikic", [1 => 1])),
            2 => (new Author("Zika", "Zikic", [2 => 2])),
            3 => (new Author("Nikola", "Nikolic", [3 => 3]))
        ];
    }

    public static function dataInitialized(): bool
    {
        return isset($_SESSION[AuthorRepositorySession::SESSION_TAG]);
    }

    public function fetchAll(): array
    {
        return $_SESSION[AuthorRepositorySession::SESSION_TAG];
    }

    public function fetch(int $id): ?Author
    {
        return $_SESSION[AuthorRepositorySession::SESSION_TAG][$id];
    }

    public function add(Author $author): bool
    {
        if (!isset($_SESSION[AuthorRepositorySession::SESSION_TAG][$author->getId()])) {
            $_SESSION[AuthorRepositorySession::SESSION_TAG][$author->getId()] = $author;

            return true;
        }

        return false;
    }

    public function edit(int $id, string $first_name, string $last_name): bool
    {
        if (isset($_SESSION[AuthorRepositorySession::SESSION_TAG][$id])) {
            $_SESSION[AuthorRepositorySession::SESSION_TAG][$id]->setFirstname($first_name);
            $_SESSION[AuthorRepositorySession::SESSION_TAG][$id]->setLastname($last_name);

            return true;
        }

        return false;
    }

    public function delete(int $id): bool
    {
        if (isset($_SESSION[AuthorRepositorySession::SESSION_TAG][$id])) {
            unset($_SESSION[AuthorRepositorySession::SESSION_TAG][$id]);

            return true;
        }

        return false;
    }

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