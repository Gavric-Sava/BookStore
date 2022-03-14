<?php

require_once $_SERVER['DOCUMENT_ROOT']."/src/data/models/Author.php";
require_once $_SERVER['DOCUMENT_ROOT']."/src/data/models/Book.php";
require_once $_SERVER['DOCUMENT_ROOT']."/src/data/repositories/AuthorSessionRepository.php";
require_once $_SERVER['DOCUMENT_ROOT']."/src/data/repositories/BookSessionRepository.php";

    function initSessionData() {
        if (!AuthorSessionRepository::dataInitialized()) {
            AuthorSessionRepository::initializeData();
        }
        if (!BookSessionRepository::dataInitialized()) {
            BookSessionRepository::initializeData();
        }
    }