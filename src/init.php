<?php

use Logeecom\Bookstore\data\repositories\authors\AuthorRepositorySession;
use Logeecom\Bookstore\data\repositories\books\BookRepositorySession;

function initSessionData()
{
    if (!AuthorRepositorySession::dataInitialized()) {
        AuthorRepositorySession::initializeData();
    }
    if (!BookRepositorySession::dataInitialized()) {
        BookRepositorySession::initializeData();
    }
}