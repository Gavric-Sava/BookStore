<?php

require_once $_SERVER['DOCUMENT_ROOT']."/src/data/models/Author.php";
require_once $_SERVER['DOCUMENT_ROOT']."/src/data/models/Book.php";
require_once $_SERVER['DOCUMENT_ROOT']."/src/data/repositories/AuthorSessionRepository.php";
require_once $_SERVER['DOCUMENT_ROOT']."/src/data/repositories/BookSessionRepository.php";

    function initSessionData() {
        AuthorSessionRepository::initializeData();
        BookSessionRepository::initializeData();
        $_SESSION["data_initialized"] = true;
    }