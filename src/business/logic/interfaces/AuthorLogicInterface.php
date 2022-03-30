<?php

namespace Logeecom\Bookstore\business\logic\interfaces;

use Logeecom\Bookstore\data_access\models\Author;

interface AuthorLogicInterface
{
    /**
     * Fetch all authors with their respective book counts.
     * @return array - Authors with respective book counts.
     */
    public function fetchAllAuthorsWithBookCount(): array;

    /**
     * Fetch author with given id.
     * @param int $id - Id of author.
     * @return Author|null - Author with given id or null if non-existent.
     */
    public function fetchAuthor(int $id): ?Author;

    /**
     * Create new author.
     * @param string $first_name - First name of new author.
     * @param string $last_name - Last name of new author.
     * @return Author|null - Newly created author of null on error.
     */
    public function createAuthor(string $first_name, string $last_name): ?Author;

    /**
     * Edit author with given id.
     * @param int $id - Id of author.
     * @param string $first_name - New first name value.
     * @param string $last_name - New last name value.
     * @return Author|null - Edited author or null on error.
     */
    public function editAuthor(int $id, string $first_name, string $last_name): ?Author;

    /**
     * Delete author with given id.
     * @param int $id - Id of author.
     * @return bool - True on success, false on failure.
     */
    public function deleteAuthor(int $id): bool;
}