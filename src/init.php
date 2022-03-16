<?php

require_once __DIR__ . "/data/repositories/authors/AuthorRepositorySession.php";
require_once __DIR__ . "/data/repositories/books/BookRepositorySession.php";

function initSessionData()
{
    if (!AuthorRepositorySession::dataInitialized()) {
        AuthorRepositorySession::initializeData();
    }
    if (!BookRepositorySession::dataInitialized()) {
        BookRepositorySession::initializeData();
    }
}