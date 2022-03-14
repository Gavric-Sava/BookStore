<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/src/controllers/BaseController.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/src/data/repositories/AuthorSessionRepository.php';

class AuthorController extends BaseController
{

    public function process(string $uri)
    {
        $authors = AuthorSessionRepository::fetchAll();
        require ($_SERVER['DOCUMENT_ROOT']."/src/views/author_list.php");
    }
}