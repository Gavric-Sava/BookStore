<?php

require_once __DIR__ . '/../../models/Book.php';
require_once __DIR__ . '/BookRepositoryInterface.php';

class BookRepositorySession implements \BookRepositoryInterface
{

    public const SESSION_TAG = "books";

    public static function initializeData(): void
    {
        $_SESSION[BookRepositorySession::SESSION_TAG] = [
            0 => (new Book("Book Name", 2001)),
            1 => (new Book("Book Name 1", 2002)),
            2 => (new Book("Book Name 2", 1997)),
            3 => (new Book("Book Name 3", 2005)),
            4 => (new Book("Book Name 4", 2006))
        ];
    }

    public static function dataInitialized(): bool
    {
        return isset($_SESSION[BookRepositorySession::SESSION_TAG]);
    }

    public function fetchAll(): array
    {
        return $_SESSION[BookRepositorySession::SESSION_TAG];
    }

    public function fetch(int $id): ?Book
    {
        return $_SESSION[BookRepositorySession::SESSION_TAG][$id];
    }

    public function add(Book $book): bool
    {
        if (!isset($_SESSION[BookRepositorySession::SESSION_TAG][$book->getId()])) {
            $_SESSION[BookRepositorySession::SESSION_TAG][$book->getId()] = $book;

            return true;
        }

        return false;
    }

    public function edit(int $id, string $title, int $year): bool
    {
        if (isset($_SESSION[BookRepositorySession::SESSION_TAG][$id])) {
            $_SESSION[BookRepositorySession::SESSION_TAG][$id]->setTitle($title);
            $_SESSION[BookRepositorySession::SESSION_TAG][$id]->setYear($year);

            return true;
        }

        return false;
    }

    public function delete(int $id): bool
    {
        if (isset($_SESSION[BookRepositorySession::SESSION_TAG][$id])) {
            unset($_SESSION[BookRepositorySession::SESSION_TAG][$id]);

            return true;
        }

        return false;
    }

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

}