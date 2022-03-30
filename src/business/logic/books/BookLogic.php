<?php

namespace Logeecom\Bookstore\business\logic\books;

use Logeecom\Bookstore\business\logic\interfaces\BookLogicInterface;
use Logeecom\Bookstore\data_access\models\Book;
use Logeecom\Bookstore\data_access\repositories\interfaces\BookRepositoryInterface;

class BookLogic implements BookLogicInterface
{
    /**
     * @var BookRepositoryInterface - Repository of book data.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private BookRepositoryInterface $bookRepository;

    /**
     * @param BookRepositoryInterface $bookRepository - Book repository interface.
     */
    public function __construct(
        BookRepositoryInterface $bookRepository
    ) {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @inheritDoc
     */
    public function fetchAllBooks(): array
    {
        return $this->bookRepository->fetchAll();
    }

    /**
     * @inheritDoc
     */
    public function fetchAllBooksFromAuthor(int $author_id): array
    {
        return $this->bookRepository->fetchAllFromAuthor($author_id);
    }

    /**
     * @inheritDoc
     */
    public function fetchBook(int $id): ?Book
    {
        return $this->bookRepository->fetch($id);
    }

    /**
     * @inheritDoc
     */
    public function createBook(string $title, int $year, int $author_id): ?Book
    {
        return $this->bookRepository->add(new Book($title, $year, $author_id));
    }

    /**
     * @inheritDoc
     */
    public function editBook(int $id, string $title, int $year): ?Book
    {
        $book = $this->bookRepository->fetch($id);
        if ($book === null) {
            return null;
        }
        return $this->bookRepository->edit($id, $title, $year, $book->getAuthorId());
    }

    /**
     * @inheritDoc
     */
    public function deleteBook(int $id): bool
    {
        return $this->bookRepository->delete($id);
    }
}