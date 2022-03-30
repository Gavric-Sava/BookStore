<?php

use Logeecom\Bookstore\business\logic\authors\AuthorLogic;
use Logeecom\Bookstore\business\logic\books\BookLogic;
use Logeecom\Bookstore\data_access\repositories\authors\AuthorRepositoryDatabase;
use Logeecom\Bookstore\data_access\repositories\books\BookRepositoryDatabase;
use Logeecom\Bookstore\presentation\multi_page\controllers\MultiPageAuthorController;
use Logeecom\Bookstore\presentation\multi_page\controllers\MultiPageBookController;
use Logeecom\Bookstore\presentation\multi_page\views\ViewTemplate;
use Logeecom\Bookstore\presentation\routers\RouteMapping;
use Logeecom\Bookstore\presentation\single_page\API\APIAuthorController;
use Logeecom\Bookstore\presentation\single_page\API\APIBookController;

$view_root_path = $_SERVER['DOCUMENT_ROOT'] . '/src/presentation/multi_page/views';

return [
    new RouteMapping(
        '/^\/(authors\/?)?$/',
        MultiPageAuthorController::class,
        'renderAuthorList',
        'GET',
        function() use ($view_root_path) {
            return [
                new AuthorLogic(new AuthorRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/create\/?$/',
        MultiPageAuthorController::class,
        'renderAuthorCreate',
        'GET',
        function() use ($view_root_path) {
            return [
                new AuthorLogic(new AuthorRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/create\/?$/',
        MultiPageAuthorController::class,
        'processAuthorCreate',
        'POST',
        function() use ($view_root_path) {
            return [
                new AuthorLogic(new AuthorRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/edit\/(\d+)\/?$/',
        MultiPageAuthorController::class,
        'renderAuthorEdit',
        'GET',
        function() use ($view_root_path) {
            return [
                new AuthorLogic(new AuthorRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/edit\/(\d+)\/?$/',
        MultiPageAuthorController::class,
        'processAuthorEdit',
        'POST',
        function() use ($view_root_path) {
            return [
                new AuthorLogic(new AuthorRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/delete\/(\d+)?$/',
        MultiPageAuthorController::class,
        'renderAuthorDelete',
        'GET',
        function() use ($view_root_path) {
            return [
                new AuthorLogic(new AuthorRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/delete\/(\d+)\/?$/',
        MultiPageAuthorController::class,
        'processAuthorDelete',
        'POST',
        function() use ($view_root_path) {
            return [
                new AuthorLogic(new AuthorRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/spa\/?$/',
        APIAuthorController::class,
        'renderSPAIndex',
        'GET',
        function() use ($view_root_path) {
            return [
                new AuthorLogic(new AuthorRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/spa\/authors\/?$/',
        APIAuthorController::class,
        'processAuthorList',
        'GET',
        function() use ($view_root_path) {
            return [
                new AuthorLogic(new AuthorRepositoryDatabase()),
            ];
        }
    ),
    new RouteMapping(
        '/^\/spa\/authors\/create\/?$/',
        APIAuthorController::class,
        'processAuthorCreate',
        'POST',
        function() use ($view_root_path) {
            return [
                new AuthorLogic(new AuthorRepositoryDatabase()),
            ];
        }
    ),
    new RouteMapping(
        '/^\/spa\/authors\/edit\/(\d+)\/?$/',
        APIAuthorController::class,
        'processAuthorEdit',
        'POST',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new RouteMapping(
        '/^\/spa\/authors\/delete\/(\d+)\/?$/',
        APIAuthorController::class,
        'processAuthorDelete',
        'POST',
        function() {
            return new AuthorLogic(new AuthorRepositoryDatabase());
        }
    ),
    new RouteMapping(
        '/^\/authors\/(\d+)(?:\/(?:books\/?)?)?$/',
        MultiPageBookController::class,
        'renderBookList',
        'GET',
        function() use ($view_root_path) {
            return [
                new BookLogic(new BookRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/(\d+)\/books\/create\/?$/',
        MultiPageBookController::class,
        'renderBookCreate',
        'GET',
        function() use ($view_root_path) {
            return [
                new BookLogic(new BookRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/(\d+)\/books\/create\/?$/',
        MultiPageBookController::class,
        'processBookCreate',
        'POST',
        function() use ($view_root_path) {
            return [
                new BookLogic(new BookRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/(?:\d*)\/books\/edit\/(\d+)\/?$/',
        MultiPageBookController::class,
        'renderBookEdit',
        'GET',
        function() use ($view_root_path) {
            return [
                new BookLogic(new BookRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/(?:\d*)\/books\/edit\/(\d+)\/?$/',
        MultiPageBookController::class,
        'processBookEdit',
        'POST',
        function() use ($view_root_path) {
            return [
                new BookLogic(new BookRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/(?:\d*)\/books\/delete\/(\d+)\/?$/',
        MultiPageBookController::class,
        'renderBookDelete',
        'GET',
        function() use ($view_root_path) {
            return [
                new BookLogic(new BookRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/authors\/(?:\d*)\/books\/delete\/(\d+)\/?$/',
        MultiPageBookController::class,
        'processBookDelete',
        'POST',
        function() use ($view_root_path) {
            return [
                new BookLogic(new BookRepositoryDatabase()),
                new ViewTemplate($view_root_path)
            ];
        }
    ),
    new RouteMapping(
        '/^\/spa\/authors\/(\d+)(?:\/(?:books\/?)?)?$/',
        APIBookController::class,
        'processBookList',
        'GET',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new RouteMapping(
        '/^\/spa\/authors\/(\d+)\/books\/create\/?$/',
        APIBookController::class,
        'processBookCreate',
        'POST',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new RouteMapping(
        '/^\/spa\/authors\/(?:\d*)\/books\/edit\/(\d+)\/?$/',
        APIBookController::class,
        'processBookEdit',
        'POST',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
    new RouteMapping(
        '/^\/spa\/authors\/(?:\d*)\/books\/delete\/(\d+)\/?$/',
        APIBookController::class,
        'processBookDelete',
        'POST',
        function() {
            return new BookLogic(new BookRepositoryDatabase());
        }
    ),
];