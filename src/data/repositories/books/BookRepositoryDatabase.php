<?php

namespace Bookstore\Data\Repository;

require_once __DIR__ . '/../../models/Book.php';
require_once __DIR__ . '/BookRepositoryInterface.php';

use Bookstore\Data\Model\Book;
use \PDO;

class BookRepositoryDatabase implements BookRepositoryInterface
{

    private const TABLE_NAME = "books";

    private PDO $PDO;

    public function __construct(PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(): array
    {
        $pdo_statement = $this->PDO->query("SELECT * FROM " . BookRepositoryDatabase::TABLE_NAME);

        if ($pdo_statement) {
            return $pdo_statement->fetchAll(PDO::FETCH_FUNC, function (int $id, string $title, int $year) {
                return new Book($title, $year, $id);
            });
        }

        return [];
    }

    /**
     * @inheritDoc
     */
    public function fetch(int $id): ?Book
    {
        $pdo_statement = $this->PDO->prepare(
            "SELECT * FROM " . BookRepositoryDatabase::TABLE_NAME . " WHERE id = :id"

        );
        $pdo_statement->bindParam(':id', $id);

        if ($pdo_statement->execute()) {
            $fetch = $pdo_statement->fetch(PDO::FETCH_ASSOC);
            if ($fetch === false) {
                return null;
            } else {
                return new Book($fetch["title"], $fetch["year"], $fetch["id"], $fetch["author_id"]);
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function add(Book $book): bool
    {
        $pdo_statement = $this->PDO->prepare(
            "INSERT INTO " .
            BookRepositoryDatabase::TABLE_NAME .
            " (title, year, author_id) VALUES(:title, :year, :author_id)"
        );

        $title = $book->getTitle();
        $year = $book->getYear();
        $author_id = $book->getAuthorId();

        $pdo_statement->bindParam(':title', $title);
        $pdo_statement->bindParam(':year', $year);
        $pdo_statement->bindParam(':author_id', $author_id);

        return $pdo_statement->execute();
    }

    /**
     * @inheritDoc
     */
    public function edit(int $id, string $title, int $year, ?int $author_id): bool
    {
        $pdo_statement = $this->PDO->prepare(
            "UPDATE " .
            BookRepositoryDatabase::TABLE_NAME .
            " SET title = :title, year = :year, author_id = :author_id " .
            "WHERE id = :id"
        );

        $pdo_statement->bindParam(':id', $id);
        $pdo_statement->bindParam(':title', $title);
        $pdo_statement->bindParam(':year', $year);
        $pdo_statement->bindParam(':author_id', $author_id);

        return $pdo_statement->execute();
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $pdo_statement = $this->PDO->prepare(
            "DELETE FROM " . BookRepositoryDatabase::TABLE_NAME . " WHERE id = :id"
        );

        $pdo_statement->bindParam(':id', $id);

        return $pdo_statement->execute();
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple(array $ids): bool
    {
        $pdo_statement = $this->PDO->prepare(
            "DELETE FROM " . BookRepositoryDatabase::TABLE_NAME . " WHERE id in :ids"
        );

        $pdo_statement->bindParam(':ids', $ids);

        return $pdo_statement->execute();
    }

}