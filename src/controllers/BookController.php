<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../data/repositories/BookSessionRepository.php';
require_once './src/util/RequestUtil.php';

class BookController extends BaseController
{

    public function process(string $path)
    {
        if (preg_match('/^\/books\/create\/?$/', $path)) {
            $this->renderBookCreate();
        } elseif (preg_match('/^\/books\/edit\/(\d+)\/?$/', $path, $matches)) {
//            print_r($matches);
            $this->renderBookEdit($matches[1]);
        } elseif (preg_match('/^\/books\/delete\/(\d+)\/?$/', $path, $matches)) {
            $this->renderBookDelete($matches[1]);
        } elseif (preg_match('/^\/books\/?$/', $path)) {
            $this->renderBookList();
        } else {
            RequestUtil::render404();
        }
    }

    private function renderBookList(): void
    {
        $books = BookSessionRepository::fetchAll();
        require($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_list.php");
    }

    private function renderBookCreate(): void
    {
        require($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_create.php");
    }

    private function renderBookEdit($id): void
    {
        $book = BookSessionRepository::fetch($id);
        if (!isset($book)) {
            RequestUtil::render404();
        } else {
            require($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_edit.php");
        }
    }

    private function renderBookDelete($id)
    {
        $book = BookSessionRepository::fetch($id);
        if (!isset($book)) {
            RequestUtil::render404();
        } else {
            require($_SERVER['DOCUMENT_ROOT'] . "/src/views/books/book_delete.php");
        }
    }
}