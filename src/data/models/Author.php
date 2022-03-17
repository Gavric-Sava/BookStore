<?php

namespace Bookstore\Data\Model;

class Author
{

    private const ID_TAG = "author_id";

    private ?int $id;
    private string $firstname;
    private string $lastname;
    private array $books;

    /**
     * Constructs Author object. Takes first and last name of author and list of ids
     * of published books.
     *
     * @param string $firstname
     * @param string $lastname
     * @param array $books
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function __construct(string $firstname, string $lastname, array $books = [])
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->books = $books;
//        $this->id = Author::generateId();
        $this->id = null;
    }

    /**
     * Gets id of the author.
     *
     * @return int Id of the author.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Sets Id of the author.
     *
     * @param id $id New id of the author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Gets firstname of the author.
     *
     * @return string Firstname of the author.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Sets firstname of the author.
     *
     * @param string $firstname New firstname of the author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * Gets lastname of the author.
     *
     * @return string Lastname of the author.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Sets lastname of the author.
     *
     * @param string $lastname New lastname of the author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * Gets array of ids of books published by the author.
     *
     * @return array - Array of ids of books published by the author.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function getBooks(): array
    {
        return $this->books;
    }

    /**
     * Sets array of ids of books published by the author.
     *
     * @param array $books New array of ids of books published by the author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function setBooks(array $books): void
    {
        $this->books = $books;
    }

    /**
     * Gets number of books published by the author.
     *
     * @return int Number of books published by the author.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function getBookCount(): int
    {
        return count($this->books);
    }

    /**
     * Removes passed id of book from array of ids of books published by the author.
     *
     * @param int $id Id of book to be removed.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function deleteBook(int $id): void
    {
        if (isset($this->books[$id])) {
            unset($this->books[$id]);
        }
    }

    /**
     * Adds passed id of book to array of ids of books published by the author.
     *
     * @param int $id - Id of book to be added.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function addBook(int $id): void
    {
        if (!isset($this->books[$id])) {
            $this->books[$id] = $id;
        }
    }

}
