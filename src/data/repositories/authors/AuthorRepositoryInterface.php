<?php

namespace Bookstore\Data\Repository;

use Bookstore\Data\Model\Author;

interface AuthorRepositoryInterface
{
    public function fetchAll(): array;

    public function fetch(int $id): ?Author;

    public function add(Author $author): bool;

    public function edit(int $id, string $first_name, string $last_name): bool;

    public function delete(int $id): bool;

    public function deleteBook(int $book_id): bool;
}