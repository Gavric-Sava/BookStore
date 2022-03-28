<?php

namespace Logeecom\Bookstore\business\logic\interfaces;

use Logeecom\Bookstore\data_access\models\Book;

interface BookLogicInterface
{
    public function fetchAllBooks(): array;

    public function fetchAllBooksFromAuthor(int $author_id): array;

    public function fetchBook(int $id): ?Book;

    public function createBook(string $title, int $year, int $author_id): ?Book;

    public function editBook(int $id, string $title, int $year): ?Book;

    public function deleteBook(int $id): bool;
}