<?php

namespace Logeecom\Bookstore\business\logic;

use Logeecom\Bookstore\data_access\models\Author;
use Logeecom\Bookstore\data_access\repositories\authors\AuthorRepositoryInterface;

class AuthorLogic
{
    /**
     * @var AuthorRepositoryInterface - Repository of author data.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private AuthorRepositoryInterface $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function fetchAllAuthorsWithBookCount(): array
    {
        return $this->authorRepository->fetchAllWithBookCount();
    }

    public function fetchAuthor(int $id): ?Author
    {
        return $this->authorRepository->fetch($id);
    }

    public function createAuthor(string $first_name, string $last_name): ?Author
    {
        return $this->authorRepository->add(new Author($first_name, $last_name));
    }

    public function editAuthor(int $id, string $first_name, string $last_name): ?Author
    {
        return $this->authorRepository->edit($id, $first_name, $last_name);
    }

    public function deleteAuthor(int $id): bool
    {
        return $this->authorRepository->delete($id);
    }

}