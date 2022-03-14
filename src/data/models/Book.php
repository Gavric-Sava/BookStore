<?php

class Book
{
    private static int $s_id = 0;
    private int $id;
    private string $name;
    private int $year;

    function __construct(string $name, int $year)
    {
        $this->name = $name;
        $this->year = $year;
        $this->id = Book::$s_id++;
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

}

