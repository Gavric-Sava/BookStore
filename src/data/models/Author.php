<?php

class Author
{
    private static int $s_id = 0;
    private int $id;
    private string $firstname;
    private string $lastname;
    private array $books;

    function __construct(string $firstname, string $lastname, array $books)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->books = $books;
        $this->id = Author::$s_id++;
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

}
