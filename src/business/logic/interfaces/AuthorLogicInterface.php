<?php

namespace Logeecom\Bookstore\business\logic\interfaces;

use Logeecom\Bookstore\data_access\models\Author;

interface AuthorLogicInterface
{
    public function fetchAllAuthorsWithBookCount(): array;

    public function fetchAuthor(int $id): ?Author;

    public function createAuthor(string $first_name, string $last_name): ?Author;

    public function editAuthor(int $id, string $first_name, string $last_name): ?Author;

    public function deleteAuthor(int $id): bool;
}