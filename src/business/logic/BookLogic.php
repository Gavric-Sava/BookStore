<?php

namespace Logeecom\Bookstore\business\logic;

use Logeecom\Bookstore\data_access\models\Book;
use Logeecom\Bookstore\data_access\repositories\books\BookRepositoryInterface;

class BookLogic
{

    private BookRepositoryInterface $bookRepository;

    public function __construct(
        BookRepositoryInterface $bookRepository
    ) {
        $this->bookRepository = $bookRepository;
    }

    public function fetchAllBooks(): array
    {
        return $this->bookRepository->fetchAll();
    }

    public function fetchBook(int $id): ?Book
    {
        return $this->bookRepository->fetch($id);
    }

    public function createBook(string $title, int $year): bool
    {
        return $this->bookRepository->add(new Book($title, $year));
    }

    public function editBook(int $id, string $title, int $year): bool
    {
        $book = $this->bookRepository->fetch($id);
        if ($book == false) {
            return false;
        }
        return $this->bookRepository->edit($id, $title, $year, $book->getAuthorId());
    }

    public function deleteBook(int $id): bool
    {
        return $this->bookRepository->delete($id);
    }
}