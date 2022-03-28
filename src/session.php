<?php

use Logeecom\Bookstore\data_access\repositories\authors\AuthorRepositorySession;
use Logeecom\Bookstore\data_access\repositories\books\BookRepositorySession;

if (session_status() === PHP_SESSION_NONE) {
    session_start();

    if (!AuthorRepositorySession::dataInitialized()) {
        AuthorRepositorySession::initializeData();
    }
    if (!BookRepositorySession::dataInitialized()) {
        BookRepositorySession::initializeData();
    }
}
