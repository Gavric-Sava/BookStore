<?php
require_once __DIR__.'/BaseController.php';
require_once __DIR__.'/../data/repositories/AuthorSessionRepository.php';

class AuthorController extends BaseController
{

    public function process(string $uri)
    {
        $authors = AuthorSessionRepository::fetchAll();
        require ($_SERVER['DOCUMENT_ROOT']."/src/views/author_list.php");
    }

}