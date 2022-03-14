<?php

abstract class AuthorSessionRepository
{

    public const SESSION_TAG = "authors";

    public static function initializeData(): void {
        $_SESSION[AuthorSessionRepository::SESSION_TAG] = [
            (new Author("Pera", "Peric", [0, 4])),
            (new Author("Mika", "Mikic", [1])),
            (new Author("Zika", "Zikic", [2])),
            (new Author("Nikola", "Nikolic", [3]))
        ];
    }

    public static function fetchAll(): array {
        return $_SESSION[AuthorSessionRepository::SESSION_TAG];
    }

    public static function dataInitialized(): bool {
        return isset($_SESSION[AuthorSessionRepository::SESSION_TAG]);
    }
}