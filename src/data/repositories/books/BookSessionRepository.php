<?php

require_once __DIR__ . "/../models/Book.php";
require_once __DIR__ . '/AuthorSessionRepository.php';

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
        return $_SESSION[BookSessionRepository::SESSION_TAG][$id];
    }

    public static function add(Book $book): void {
        $books_in_session = $_SESSION[BookSessionRepository::SESSION_TAG];
        if (!isset($books_in_session[$book->getId()])) {
            $books_in_session[$book->getId()] = $book;
            $_SESSION[BookSessionRepository::SESSION_TAG] = $books_in_session;
        }
    }

    public static function edit(int $id, string $title, int $year): void {
        $books_in_session = $_SESSION[BookSessionRepository::SESSION_TAG];
        if (isset($books_in_session[$id])) {
            $books_in_session[$id]->setTitle($title);
            $books_in_session[$id]->setYear($year);
        }
    }

    public static function delete(int $id): void
    {
        $books_in_session = $_SESSION[BookSessionRepository::SESSION_TAG];
        if (isset($books_in_session[$id])) {
            AuthorSessionRepository::deleteBook($id);
            unset($books_in_session[$id]);
        }
        $_SESSION[BookSessionRepository::SESSION_TAG] = $books_in_session;
    }

    public static function deleteMultiple(array $ids): void
    {
        $books_in_session = $_SESSION[BookSessionRepository::SESSION_TAG];
        foreach($ids as $book_id) {
            unset($books_in_session[$book_id]);
        }
        $_SESSION[BookSessionRepository::SESSION_TAG] = $books_in_session;
    }

}