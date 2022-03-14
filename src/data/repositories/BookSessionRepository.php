<?php

require_once __DIR__ . "/../models/Book.php";
require_once __DIR__ . "/SessionRepositoryInterface.php";

abstract class BookSessionRepository implements SessionRepositoryInterface
{

    public const SESSION_TAG = "books";

    public static function initializeData(): void
    {
        $_SESSION[BookSessionRepository::SESSION_TAG] = [
            (new Book("Book Name", 2001)),
            (new Book("Book Name 1", 2002)),
            (new Book("Book Name 2", 1997)),
            (new Book("Book Name 3", 2005)),
            (new Book("Book Name 4", 2006))
        ];
    }

    public static function fetchAll(): array
    {
        return $_SESSION[BookSessionRepository::SESSION_TAG];
    }

    public static function dataInitialized(): bool
    {
        return isset($_SESSION[BookSessionRepository::SESSION_TAG]);
    }
}