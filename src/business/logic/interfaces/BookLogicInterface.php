<?php

namespace Logeecom\Bookstore\business\logic\interfaces;

use Logeecom\Bookstore\data_access\models\Book;

interface BookLogicInterface
{
    /**
     * Fetch all books.
     * @return array - Array of books.
     */
    public function fetchAllBooks(): array;

    /**
     * Fetch all books of the given author.
     * @param int $author_id - Id of author.
     * @return array - Array of books.
     */
    public function fetchAllBooksFromAuthor(int $author_id): array;

    /**
     * Fetch book with given id.
     * @param int $id
     * @return Book|null - Book with given id or null if non-existent.
     */
    public function fetchBook(int $id): ?Book;

    /**
     * Create new book.
     * @param string $title - Title of new book.
     * @param int $year - Year of publishing of new book.
     * @param int $author_id - Id of author of new book.
     * @return Book|null - Newly created book of null on error.
     */
    public function createBook(string $title, int $year, int $author_id): ?Book;

    /**
     * Edit book with given id.
     * @param int $id - Id of book.
     * @param string $title - New title value.
     * @param int $year - New year value.
     * @return Book|null - Edited book or null on error.
     */
    public function editBook(int $id, string $title, int $year): ?Book;

    /**
     * Delete book with given id.
     * @param int $id - Id of book.
     * @return bool - True on success, false on failure.
     */
    public function deleteBook(int $id): bool;
}