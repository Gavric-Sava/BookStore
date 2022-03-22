<?php

namespace Logeecom\Bookstore\data_access\repositories\authors;

use Logeecom\Bookstore\data_access\models\Author;
use PDO;

class AuthorRepositoryDatabase implements AuthorRepositoryInterface
{

    private const TABLE_NAME = "authors";

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
        $pdo_statement = $this->PDO->query("SELECT * FROM " . AuthorRepositoryDatabase::TABLE_NAME);

        $parse_fetched_rows = function (int $id, string $firstname, string $lastname) {
            return new Author($firstname, $lastname, $id);
        };

        if ($pdo_statement) {
            return $pdo_statement->fetchAll(PDO::FETCH_FUNC, $parse_fetched_rows);
        }

        return [];
    }

    /**
     * @inheritDoc
     */
    public function fetch(int $id): ?Author
    {
        $pdo_statement = $this->PDO->prepare(
            "SELECT * FROM " . AuthorRepositoryDatabase::TABLE_NAME . " WHERE id = :id"
        );

        $pdo_statement->bindParam(':id', $id);

        if ($pdo_statement->execute()) {
            $fetch = $pdo_statement->fetch(PDO::FETCH_ASSOC);
            if ($fetch === false) {
                return null;
            } else {
                return new Author($fetch["firstname"], $fetch["lastname"], $fetch["id"]);
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function add(Author $author): bool
    {
        $pdo_statement = $this->PDO->prepare(
            "INSERT INTO " .
            AuthorRepositoryDatabase::TABLE_NAME .
            " (firstname, lastname) VALUES(:firstname, :lastname)"
        );

        $firstname = $author->getFirstname();
        $lastname = $author->getLastname();

        $pdo_statement->bindParam(':firstname', $firstname);
        $pdo_statement->bindParam(':lastname', $lastname);

        return $pdo_statement->execute();
    }

    /**
     * @inheritDoc
     */
    public function edit(int $id, string $firstname, string $lastname): bool
    {
        $pdo_statement = $this->PDO->prepare(
            "UPDATE " .
            AuthorRepositoryDatabase::TABLE_NAME .
            " SET id = :id, firstname = :firstname, lastname = :lastname " .
            "WHERE id = :id"
        );

        $pdo_statement->bindParam(':id', $id);
        $pdo_statement->bindParam(':firstname', $firstname);
        $pdo_statement->bindParam(':lastname', $lastname);

        return $pdo_statement->execute();
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        $pdo_statement = $this->PDO->prepare(
            "DELETE FROM " . AuthorRepositoryDatabase::TABLE_NAME . " WHERE id = :id"
        );

        $pdo_statement->bindParam(':id', $id);

        return $pdo_statement->execute();
    }

    /**
     * @inheritDoc
     */
    public function fetchAllWithBookCount(): array
    {
        $pdo_statement = $this->PDO->query(
            "SELECT a.*, COUNT(b.id) AS book_count
                      FROM " . AuthorRepositoryDatabase::TABLE_NAME . " a
                      LEFT JOIN books b ON a.id = b.author_id
                      GROUP BY a.id"
        );

        $parse_fetched_rows = function (int $id, string $firstname, string $lastname, int $book_count) {
            return [
                "author" => new Author($firstname, $lastname, $id),
                "book_count" => $book_count
            ];
        };

        if ($pdo_statement) {
            return $pdo_statement->fetchAll(PDO::FETCH_FUNC, $parse_fetched_rows);
        }

        return [];
    }
}