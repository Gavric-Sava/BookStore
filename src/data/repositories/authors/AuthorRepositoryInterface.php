<?php

namespace Bookstore\Data\Repository;

use Bookstore\Data\Model\Author;

interface AuthorRepositoryInterface
{
    /**
     * Fetch all authors.
     *
     * @return array Array of authors.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function fetchAll(): array;

    /**
     * Fetch an author.
     *
     * @param int $id Id of author to be fetched.
     * @return Author|null Author if found. Null otherwise.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function fetch(int $id): ?Author;

    /**
     * Add an author.
     *
     * @param Author $author Author to be added.
     * @return bool True if adding successful. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function add(Author $author): bool;

    /**
     * Edit an author.
     *
     * @param int $id Id of author to be edited.
     * @param string $first_name New firstname value.
     * @param string $last_name New lastname value.
     * @return bool True if editing successful. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function edit(int $id, string $first_name, string $last_name): bool;

    /**
     * Delete an author.
     *
     * @param int $id Id of author to be deleted.
     * @return bool True if deletion successful. Otherwise, not.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function delete(int $id): bool;

    /**
     * Remove book from corresponding author.
     *
     * @param int $book_id Id of book to be removed.
     * @return bool True if deletion successful. Otherwise, not.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function deleteBook(int $book_id): bool;
}