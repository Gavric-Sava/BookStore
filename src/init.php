<?php

require_once __DIR__ . "/data/repositories/authors/AuthorRepositorySession.php";
require_once __DIR__ . "/data/repositories/books/BookRepositorySession.php";

use Bookstore\Data\Repository\AuthorRepositorySession;
use Bookstore\Data\Repository\BookRepositorySession;

function initSessionData()
{
    if (!AuthorRepositorySession::dataInitialized()) {
        AuthorRepositorySession::initializeData();
    }
    if (!BookRepositorySession::dataInitialized()) {
        BookRepositorySession::initializeData();
    }
}