<?php

namespace Logeecom\Bookstore\data_access\repositories\books;

use Logeecom\Bookstore\data_access\models\Book;
use PDO;

class BookRepositoryDatabase implements BookRepositoryInterface
{
    /**
     * Name of table in DB.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private const TABLE_NAME = "books";

    /**
     * @var PDO - Connection to DB.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
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
            return $pdo_statement->fetchAll(PDO::FETCH_FUNC, function (
                int $id,
                string $title,
                int $year,
                int $author_id) {
                return new Book($title, $year, $author_id, $id);
            });
        }

        return [];
    }

    public function fetchAllFromAuthor(int $author_id): array
    {
        $pdo_statement = $this->PDO->query("SELECT *".
            " FROM " . BookRepositoryDatabase::TABLE_NAME .
            " WHERE " . "author_id = " . $author_id
        );

        if ($pdo_statement) {
            return $pdo_statement->fetchAll(PDO::FETCH_FUNC, function (
                int $id,
                string $title,
                int $year,
                int $author_id) {
                return new Book($title, $year, $author_id, $id);
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
                return new Book($fetch["title"], $fetch["year"], $fetch["author_id"], $fetch["id"]);
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function add(Book $book): ?Book
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

        if ($pdo_statement->execute()) {
            $lastInsertId = $this->PDO->lastInsertId();
            return $this->fetch($lastInsertId);
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function edit(int $id, string $title, int $year, ?int $author_id): ?Book
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

        if ($pdo_statement->execute()) {
            return $this->fetch($id);
        }

        return null;
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

}