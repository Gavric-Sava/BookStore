<?php

namespace Logeecom\Bookstore\business\logic\authors;

use Logeecom\Bookstore\business\logic\interfaces\AuthorLogicInterface;
use Logeecom\Bookstore\data_access\models\Author;
use Logeecom\Bookstore\data_access\repositories\interfaces\AuthorRepositoryInterface;

class AuthorLogic implements AuthorLogicInterface
{
    /**
     * @var AuthorRepositoryInterface - Repository of author data.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private AuthorRepositoryInterface $authorRepository;

    /**
     * @param AuthorRepositoryInterface $authorRepository - Author repository interface.
     */
    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * @inheritDoc
     */
    public function fetchAllAuthorsWithBookCount(): array
    {
        return $this->authorRepository->fetchAllWithBookCount();
    }

    /**
     * @inheritDoc
     */
    public function fetchAuthor(int $id): ?Author
    {
        return $this->authorRepository->fetch($id);
    }

    /**
     * @inheritDoc
     */
    public function createAuthor(string $first_name, string $last_name): ?Author
    {
        return $this->authorRepository->add(new Author($first_name, $last_name));
    }

    /**
     * @inheritDoc
     */
    public function editAuthor(int $id, string $first_name, string $last_name): ?Author
    {
        return $this->authorRepository->edit($id, $first_name, $last_name);
    }

    /**
     * @inheritDoc
     */
    public function deleteAuthor(int $id): bool
    {
        return $this->authorRepository->delete($id);
    }

}