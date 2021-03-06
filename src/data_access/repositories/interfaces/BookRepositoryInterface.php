<?php

namespace Logeecom\Bookstore\data_access\repositories\interfaces;

use Logeecom\Bookstore\data_access\models\Book;

interface BookRepositoryInterface
{
    /**
     * Fetch all books.
     *
     * @return array Array of books.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function fetchAll(): array;

    /**
     * Fetch all books from the given author.
     *
     * @param int $author_id - Id of the author.
     * @return array Array of books.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function fetchAllFromAuthor(int $author_id): array;

    /**
     * Fetch a book.
     *
     * @param int $id Id of book to be fetched.
     * @return Book|null Book if found. Null otherwise.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function fetch(int $id): ?Book;

    /**
     * Add a book.
     *
     * @param Book $book
     * @return Book|null Book object if adding successful. Otherwise, null.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function add(Book $book): ?Book;

    /**
     * Edit a book.
     *
     * @param int $id Id of book to be edited.
     * @param string $title New title value.
     * @param int $year New year value.
     * @param ?int $author_id New author Id value.
     * @return Book|null Book object if editing successful. Otherwise, null.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function edit(int $id, string $title, int $year, ?int $author_id): ?Book;

    /**
     * Delete a book.
     *
     * @param int $id Id of book to be deleted.
     * @return bool True if deletion successful. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function delete(int $id): bool;

}