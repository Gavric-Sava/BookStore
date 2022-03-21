<?php

namespace Bookstore\Data\Model;

class Book
{

    private ?int $id;
    private string $title;
    private int $year;
    private ?int $author_id;

    /**
     * Constructs Book object. Takes title of book and year of publishing.
     *
     * @param string $title Title of the book.
     * @param int $year Year published of the book.
     * @param ?int $id Nullable Id of the book.
     * @param ?int $author_id Nullable Id of the author of the book.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function __construct(string $title, int $year, ?int $id = null, int $author_id = null)
    {
        $this->title = $title;
        $this->year = $year;
        $this->id = $id;
        $this->author_id = $author_id;
    }

    /**
     * Gets Id value of the book.
     *
     * @return ?int Nullable Id of the book.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Sets Id of the book.
     *
     * @param ?int $id New nullable Id of the book.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function setId(?int $id): void
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

    /**
     * Gets Id of the author of the book.
     *
     * @return ?int Nullable Id of the author.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    /**
     * Sets Id of the author of the book.
     *
     * @param ?int $author_id New nullable Id of the author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function setAuthorId(?int $author_id): void
    {
        $this->author_id = $author_id;
    }


}
