<?php

namespace Bookstore\Data\Model;

class Author
{

    private const ID_TAG = "author_id";

    private int $id;
    private string $firstname;
    private string $lastname;
    private array $books;

    public function __construct(string $firstname, string $lastname, array $books = [])
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->books = $books;
        $this->id = Author::generateId();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getBooks(): array
    {
        return $this->books;
    }

    public function setBooks(array $books): void
    {
        $this->books = $books;
    }

    public function getBookCount(): int
    {
        return count($this->books);
    }

    public function deleteBook(int $id): void
    {
        if (isset($this->books[$id])) {
            unset($this->books[$id]);
        }
    }

    public function addBook(int $id): void
    {
        if (!isset($this->books[$id])) {
            $this->books[$id] = $id;
        }
    }

    private static function generateId(): int
    {
        if (!isset($_SESSION[Author::ID_TAG])) {
            $_SESSION[Author::ID_TAG] = 1;
            return 0;
        } else {
            return $_SESSION[Author::ID_TAG]++;
        }
    }

}
