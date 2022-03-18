<?php

namespace Bookstore\Data\Repository;

use Bookstore\Data\Model\Book;

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
     * @param Book $author Book to be added.
     * @return bool True if adding successful. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function add(Book $book): bool;

    /**
     * Edit a book.
     *
     * @param int $id Id of book to be edited.
     * @param string $title New title value.
     * @param int $year New year value.
     * @param ?int $author_id New author Id value.
     * @return bool True if editing successful. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function edit(int $id, string $title, int $year, ?int $author_id): bool;

    /**
     * Delete a book.
     *
     * @param int $id Id of book to be deleted.
     * @return bool True if deletion successful. Otherwise, not.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function delete(int $id): bool;

}