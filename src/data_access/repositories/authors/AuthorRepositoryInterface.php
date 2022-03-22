<?php

namespace Logeecom\Bookstore\data_access\repositories\authors;

use Logeecom\Bookstore\data_access\models\Author;

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
     * @param string $firstname New firstname value.
     * @param string $lastname New lastname value.
     * @return bool True if editing successful. Otherwise, false.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function edit(int $id, string $firstname, string $lastname): bool;

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
     * Fetches all authors and their respective book counts.
     *
     * @return array Array of author-book count pairs accessible with "author" and "book_count" keys.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function fetchAllWithBookCount(): array;
}