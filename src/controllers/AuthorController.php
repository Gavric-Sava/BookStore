<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../data/repositories/AuthorSessionRepository.php';
require_once './src/util/RequestUtil.php';

class AuthorController extends BaseController
{

    public function process(string $path)
    {
        if (preg_match('/^\/authors\/create\/?$/', $path)) {
            $this->renderAuthorCreate();
        } elseif (preg_match('/^\/authors\/edit\/(\d+)\/?$/', $path, $matches)) {
//            print_r($matches);
            $this->renderAuthorEdit($matches[1]);
        } elseif (preg_match('/^\/authors\/delete\/(\d+)\/?$/', $path, $matches)) {
            $this->renderAuthorDelete($matches[1]);
        } elseif (preg_match('/^\/(?:authors\/?)?$/', $path)) {
            $this->renderAuthorList();
        } else {
            RequestUtil::render404();
        }
    }

    private function renderAuthorList(): void
    {
        $authors = AuthorSessionRepository::fetchAll();
        require($_SERVER['DOCUMENT_ROOT'] . "/src/views/author_list.php");
    }

    private function renderAuthorCreate(): void
    {
        require($_SERVER['DOCUMENT_ROOT'] . "/src/views/author_create.php");
    }

    private function renderAuthorEdit($id): void
    {
        $author = AuthorSessionRepository::fetch($id);
        if (!isset($author)) {
            RequestUtil::render404();
        } else {
            require($_SERVER['DOCUMENT_ROOT'] . "/src/views/author_edit.php");
        }
    }

    private function renderAuthorDelete($id)
    {
        $author = AuthorSessionRepository::fetch($id);
        if (!isset($author)) {
            RequestUtil::render404();
        } else {
            require($_SERVER['DOCUMENT_ROOT'] . "/src/views/author_delete.php");
        }
    }

}