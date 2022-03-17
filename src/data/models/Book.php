<?php

namespace Bookstore\Data\Model;

class Book
{

    private const ID_TAG = "book_id";

    private ?int $id;
    private string $title;
    private int $year;

    /**
     * Constructs Book object. Takes title of book and year of publishing.
     *
     * @param string $title
     * @param int $year
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function __construct(string $title, int $year)
    {
        $this->title = $title;
        $this->year = $year;
        $this->id = null;
    }

    /**
     * Gets id value of the book.
     *
     * @return int Id of the book.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets id of the book.
     *
     * @param int $id New id of the book.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets title of the book.
     *
     * @return string Title of the book.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets title of the book.
     *
     * @param string $title New title of the book.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Gets year of publishing of the book.
     *
     * @return int Year of the book.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * Sets year of publishing of the book.
     *
     * @param int $year New year of the book.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

}
