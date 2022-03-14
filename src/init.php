<?php
require_once __DIR__."/data/repositories/AuthorSessionRepository.php";
require_once __DIR__."/data/repositories/BookSessionRepository.php";

    function initSessionData() {
        if (!AuthorSessionRepository::dataInitialized()) {
            AuthorSessionRepository::initializeData();
        }
        if (!BookSessionRepository::dataInitialized()) {
            BookSessionRepository::initializeData();
        }
    }