<?php

namespace Bookstore\Data\Model;

class Author
{

    private const ID_TAG = "author_id";

    private ?int $id;
    private string $firstname;
    private string $lastname;

    /**
     * Constructs Author object. Takes first and last name of author and list of Ids
     * of published books.
     *
     * @param string $firstname First name of the author.
     * @param string $lastname Last name of the author.
     * @param ?int $id Id of the author.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function __construct(string $firstname, string $lastname, ?int $id = null)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->id = $id;
    }

    /**
     * Gets nullable Id of the author.
     *
     * @return int Nullable Id of the author.
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
     * @param ?int $id New nullable Id of the author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function setId(?int $id): void
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

}
