<?php

namespace Bookstore\Data\Repository;

use Bookstore\Data\Model\Book;

interface BookRepositoryInterface
{
    public function fetchAll(): array;

    public function fetch(int $id): ?Book;

    public function add(Book $book): bool;

    public function edit(int $id, string $title, int $year): bool;

    public function delete(int $id): bool;

    public function deleteMultiple(array $ids): bool;
}