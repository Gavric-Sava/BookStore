<?php

class Book
{

    private const ID_TAG = "book_id";

    private int $id;
    private string $title;
    private int $year;

    public function __construct(string $title, int $year)
    {
        $this->title = $title;
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
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
