<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../data/repositories/AuthorSessionRepository.php';
require_once './src/util/RequestUtil.php';

class AuthorController extends BaseController
{

    public function process(string $path)
    {
        if (preg_match('/^\/authors\/create\/?$/', $path)) {
            $this->processAuthorCreate();
        } elseif (preg_match('/^\/authors\/edit\/(\d+)\/?$/', $path, $matches)) {
//            print_r($matches);
            $this->processAuthorEdit($matches[1]);
        } elseif (preg_match('/^\/authors\/delete\/(\d+)\/?$/', $path, $matches)) {
            $this->processAuthorDelete($matches[1]);
        } elseif (preg_match('/^\/(?:authors\/?)?$/', $path)) {
            $this->processAuthorList();
        } else {
            RequestUtil::render404();
        }
    }

    private function processAuthorList(): void
    {
        $authors = AuthorSessionRepository::fetchAll();
        require($_SERVER['DOCUMENT_ROOT'] . "/src/views/author_list.php");
    }

    private function processAuthorCreate(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            // TODO validate...

            AuthorSessionRepository::add(new Author($first_name, $last_name));

//            header("Location: .");
            header('Location: http://bookstore.test');
        } else {
            require($_SERVER['DOCUMENT_ROOT'] . "/src/views/author_create.php");
        }
    }

    private function processAuthorEdit($id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];
            // TODO validate...

            AuthorSessionRepository::edit($id, $first_name, $last_name);

            header('Location: http://bookstore.test');
        } else {
            $author = AuthorSessionRepository::fetch($id);
            if (!isset($author)) {
                RequestUtil::render404();
            } else {
                require($_SERVER['DOCUMENT_ROOT'] . "/src/views/author_edit.php");
            }
        }
    }

    private function processAuthorDelete($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            AuthorSessionRepository::delete($id);

            header('Location: http://bookstore.test');
        } else {
            $author = AuthorSessionRepository::fetch($id);
            if (!isset($author)) {
                RequestUtil::render404();
            } else {
                require($_SERVER['DOCUMENT_ROOT'] . "/src/views/author_delete.php");
            }
        }
    }

}