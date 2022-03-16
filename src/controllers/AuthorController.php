<?php

namespace Bookstore\Controller;

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../data/repositories/authors/AuthorRepositoryInterface.php';
require_once __DIR__ . '/../data/repositories/books/BookRepositoryInterface.php';
require_once './src/util/RequestUtil.php';

use Bookstore\Data\Model\Author;
use Bookstore\Data\Repository\{AuthorRepositoryInterface, BookRepositoryInterface};
use Bookstore\Util\RequestUtil;

class AuthorController extends BaseController
{

    /**
     * @var AuthorRepositoryInterface Interface towards Author repository.
     *
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private AuthorRepositoryInterface $authorRepository;

    /**
     * @var BookRepositoryInterface Interface towards Book repository.
     *
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private BookRepositoryInterface $bookRepository;

    /**
     * Constructs AuthorController object. Takes data repositories.
     *
     * @param AuthorRepositoryInterface $authorRepository Data repository for Author entity.
     * @param BookRepositoryInterface $bookRepository Data repository for Book entity.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function __construct(
        AuthorRepositoryInterface $authorRepository,
        BookRepositoryInterface $bookRepository
    ) {
        $this->authorRepository = $authorRepository;
        $this->bookRepository = $bookRepository;
    }

    /**
     * Parses path and processes the request.
     *
     * @param string $path Path of the request.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function process(string $path): void
    {
        if (preg_match('/^\/authors\/create\/?$/', $path)) {
            $this->processAuthorCreate();
        } elseif (preg_match('/^\/authors\/edit\/(\d+)\/?$/', $path, $matches)) {
            $this->processAuthorEdit($matches[1]);
        } elseif (preg_match('/^\/authors\/delete\/(\d+)\/?$/', $path, $matches)) {
            $this->processAuthorDelete($matches[1]);
        } elseif (preg_match('/^\/(?:authors\/?)?$/', $path)) {
            $this->processAuthorList();
        } else {
            RequestUtil::render404();
        }
    }

    /**
     * Implementation of the 'Author list' use case.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private function processAuthorList(): void
    {
        $authors = $this->authorRepository->fetchAll();
        require($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_list.php");
    }

    /**
     * Implementation of the 'Author create' use case.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private function processAuthorCreate(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            $errors = AuthorController::validateFormInput($first_name, $last_name);

            if (empty($errors)) {
                $this->authorRepository->add(new Author($first_name, $last_name));
                header('Location: http://bookstore.test');
            } else {
                $first_name_error = $errors["first_name_error"];
                $last_name_error = $errors["last_name_error"];

                include($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_create.php");
            }
        } else {
            include($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_create.php");
        }
    }

    /**
     * Implementation of the 'Author edit' use case.
     *
     * @param $id Id of the author to be edited.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private function processAuthorEdit($id): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = $_POST["first_name"];
            $last_name = $_POST["last_name"];

            $errors = AuthorController::validateFormInput(
                $first_name,
                $last_name
            );

            if (empty($errors)) {
                $this->authorRepository->edit($id, $first_name, $last_name);
                header('Location: http://bookstore.test');
            } else {
                $first_name_error = $errors["first_name_error"];
                $last_name_error = $errors["last_name_error"];

                $author = $this->authorRepository->fetch($id);
                include($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_edit.php");
            }
        } else {
            $author = $this->authorRepository->fetch($id);
            if (!isset($author)) {
                RequestUtil::render404();
            } else {
                include($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_edit.php");
            }
        }
    }

    /**
     * Implementation of the 'Author delete' use case.
     *
     * @param $id Id of the author to be deleted.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private function processAuthorDelete($id)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $books = $this->authorRepository->fetch($id)->getBooks();
            if ($this->authorRepository->delete($id)) {
                $this->bookRepository->deleteMultiple($books);
            }

            header('Location: http://bookstore.test');
        } else {
            $author = $this->authorRepository->fetch($id);
            if (!isset($author)) {
                RequestUtil::render404();
            } else {
                require($_SERVER['DOCUMENT_ROOT'] . "/src/views/authors/author_delete.php");
            }
        }
    }

    /**
     * Validation of input form data for 'Author create' and 'Author edit' use cases.
     *
     * @param string $first_name First name of the author to be created/edited.
     * @param string $last_name Last name of the author to be created/edited.
     * @return string[]|null List of errors or null, if no errors occurred.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    private function validateFormInput(string $first_name, string $last_name): ?array
    {
        $first_name_error = "";
        $last_name_error = "";

        if (!RequestUtil::validateNotEmpty($first_name)) {
            $first_name_error = "First name is required.";
        } else {
            $first_name = RequestUtil::sanitizeData($first_name);
            if (!RequestUtil::validateAlphabetical($first_name)) {
                $first_name_error = "First name is not in a valid format.";
            }
        }

        if (!RequestUtil::validateNotEmpty($last_name)) {
            $last_name_error = "Last name is required.";
        } else {
            $last_name = RequestUtil::sanitizeData($last_name);
            if (!RequestUtil::validateAlphabetical($last_name)) {
                $last_name_error = "Last name is not in a valid format.";
            }
        }

        if (!($first_name_error == "" && $last_name_error == "")) {
            return [
                "first_name_error" => $first_name_error,
                "last_name_error" => $last_name_error
            ];
        }

        return null;
    }
}