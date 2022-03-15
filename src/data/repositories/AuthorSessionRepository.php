<?php

require_once __DIR__ . "/../models/Author.php";

abstract class AuthorSessionRepository
{

    public const SESSION_TAG = "authors";

    public static function initializeData(): void
    {
        $_SESSION[AuthorSessionRepository::SESSION_TAG] = [
            0 => (new Author("Pera", "Peric", [0, 4])),
            1 => (new Author("Mika", "Mikic", [1])),
            2 => (new Author("Zika", "Zikic", [2])),
            3 => (new Author("Nikola", "Nikolic", [3]))
        ];
    }

    public static function fetchAll(): array
    {
        return $_SESSION[AuthorSessionRepository::SESSION_TAG];
    }

    public static function dataInitialized(): bool
    {
        return isset($_SESSION[AuthorSessionRepository::SESSION_TAG]);
    }

    public static function fetch(int $id): ?Author
    {
        return $_SESSION[AuthorSessionRepository::SESSION_TAG][$id];
    }

    public static function add(Author $author): void
    {
        $authors_in_session = $_SESSION[AuthorSessionRepository::SESSION_TAG];
        if (!isset($authors_in_session[$author->getId()])) {
            $authors_in_session[$author->getId()] = $author;
            $_SESSION[AuthorSessionRepository::SESSION_TAG] = $authors_in_session;
        }
    }

    public static function edit(int $id, string $first_name, string $last_name): void
    {
        $authors_in_session = $_SESSION[AuthorSessionRepository::SESSION_TAG];
        if (isset($authors_in_session[$id])) {
            $authors_in_session[$id]->setFirstname($first_name);
            $authors_in_session[$id]->setLastname($last_name);
        }
    }

    public static function delete(int $id): void
    {
        $authors_in_session = $_SESSION[AuthorSessionRepository::SESSION_TAG];
        if (isset($_SESSION[AuthorSessionRepository::SESSION_TAG][$id])) {
            unset($authors_in_session[$id]);
            $_SESSION[AuthorSessionRepository::SESSION_TAG] = $authors_in_session;
        }
    }

}