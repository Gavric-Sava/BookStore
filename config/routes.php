<?php

use Logeecom\Bookstore\business\logic\authors\AuthorLogic;
use Logeecom\Bookstore\business\logic\books\BookLogic;
use Logeecom\Bookstore\data_access\repositories\authors\AuthorRepositoryDatabase;
use Logeecom\Bookstore\data_access\repositories\books\BookRepositoryDatabase;
use Logeecom\Bookstore\presentation\multi_page\controllers\MultiPageAuthorController;
use Logeecom\Bookstore\presentation\multi_page\controllers\MultiPageBookController;
use Logeecom\Bookstore\presentation\routers\Mapping;
use Logeecom\Bookstore\presentation\single_page\API\APIAuthorController;
use Logeecom\Bookstore\presentation\single_page\API\APIBookController;

return [
    new Mapping(
        '/^\/(authors\/?)?$/',
        MultiPageAuthorController::class,
        'renderAuthorList',
        'GET',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/create\/?$/',
        MultiPageAuthorController::class,
        'renderAuthorCreate',
        'GET',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/create\/?$/',
        MultiPageAuthorController::class,
        'processAuthorCreate',
        'POST',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/edit\/(\d+)\/?$/',
        MultiPageAuthorController::class,
        'renderAuthorEdit',
        'GET',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/edit\/(\d+)\/?$/',
        MultiPageAuthorController::class,
        'processAuthorEdit',
        'POST',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/delete\/(\d+)?$/',
        MultiPageAuthorController::class,
        'renderAuthorDelete',
        'GET',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/delete\/(\d+)\/?$/',
        MultiPageAuthorController::class,
        'processAuthorDelete',
        'POST',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/spa\/?$/',
        APIAuthorController::class,
        'renderSPAIndex',
        'GET',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/spa\/authors\/?$/',
        APIAuthorController::class,
        'processAuthorList',
        'GET',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/spa\/authors\/create\/?$/',
        APIAuthorController::class,
        'processAuthorCreate',
        'POST',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/spa\/authors\/edit\/(\d+)\/?$/',
        APIAuthorController::class,
        'processAuthorEdit',
        'POST',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/spa\/authors\/delete\/(\d+)\/?$/',
        APIAuthorController::class,
        'processAuthorDelete',
        'POST',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/(\d+)(?:\/(?:books\/?)?)?$/',
        MultiPageBookController::class,
        'renderBookList',
        'GET',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/(\d+)\/books\/create\/?$/',
        MultiPageBookController::class,
        'renderBookCreate',
        'GET',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/(\d+)\/books\/create\/?$/',
        MultiPageBookController::class,
        'processBookCreate',
        'POST',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/(?:\d*)\/books\/edit\/(\d+)\/?$/',
        MultiPageBookController::class,
        'renderBookEdit',
        'GET',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/(?:\d*)\/books\/edit\/(\d+)\/?$/',
        MultiPageBookController::class,
        'processBookEdit',
        'POST',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/(?:\d*)\/books\/delete\/(\d+)\/?$/',
        MultiPageBookController::class,
        'renderBookDelete',
        'GET',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/authors\/(?:\d*)\/books\/delete\/(\d+)\/?$/',
        MultiPageBookController::class,
        'processBookDelete',
        'POST',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/spa\/authors\/(\d+)(?:\/(?:books\/?)?)?$/',
        APIBookController::class,
        'processBookList',
        'GET',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/spa\/authors\/(\d+)\/books\/create\/?$/',
        APIBookController::class,
        'processBookCreate',
        'POST',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/spa\/authors\/(?:\d*)\/books\/edit\/(\d+)\/?$/',
        APIBookController::class,
        'processBookEdit',
        'POST',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new Mapping(
        '/^\/spa\/authors\/(?:\d*)\/books\/delete\/(\d+)\/?$/',
        APIBookController::class,
        'processBookDelete',
        'POST',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
];