<?php

require_once __DIR__ . "/../models/Book.php";

abstract class BookSessionRepository
{

    public const SESSION_TAG = "books";

    public static function initializeData(): void
    {
        $_SESSION[BookSessionRepository::SESSION_TAG] = [
            0 => (new Book("Book Name", 2001)),
            1 => (new Book("Book Name 1", 2002)),
            2 => (new Book("Book Name 2", 1997)),
            3 => (new Book("Book Name 3", 2005)),
            4 => (new Book("Book Name 4", 2006))
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

    public static function fetch(int $id): ?Book {
        // TODO
        return null;
    }

    public static function add(Book $book): void {
        // TODO
        return;
    }

    public static function edit(Book $book): void {
        // TODO
        return;
    }

    public static function delete(int $id): void {
        // TODO
        return;
    }
}