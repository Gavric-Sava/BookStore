<?php

class Book
{

    private const ID_TAG = "book_id";

    private int $id;
    private string $name;
    private int $year;

    public function __construct(string $name, int $year)
    {
        $this->name = $name;
        $this->year = $year;
        $this->id = Book::generateId();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    private static function generateId(): int
    {
        if (!isset($_SESSION[Book::ID_TAG])) {
            $_SESSION[Book::ID_TAG] = 1;
            return 0;
        } else {
            return $_SESSION[Book::ID_TAG]++;
        }
    }

}
