<?php

namespace Logeecom\Bookstore\presentation\single_page\API;

use Logeecom\Bookstore\business\logic\interfaces\AuthorLogicInterface;
use Logeecom\Bookstore\presentation\base_controllers\BaseAuthorController;

class APIAuthorController extends BaseAuthorController
{
    /**
     * @var AuthorLogicInterface - Author business logic.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private AuthorLogicInterface $authorLogic;

    public function __construct(AuthorLogicInterface $authorLogic)
    {
        $this->authorLogic = $authorLogic;
    }

    /**
     * Renders SPA index file.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function renderSPAIndex()
    {
        include $_SERVER['DOCUMENT_ROOT'] . "/src/presentation/single_page/frontend/index.php";
    }

    /**
     * Returns author list view.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processAuthorList(): void
    {
        $authors_with_book_count = $this->authorLogic->fetchAllAuthorsWithBookCount();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($authors_with_book_count);
    }

    /**
     * Returns author create form view. On error returns form view with errors.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processAuthorCreate(): void
    {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];

        $errors = $this->validateFormInput($first_name, $last_name);

        if (empty($errors)) {
            $author = $this->authorLogic->createAuthor($first_name, $last_name);
            if ($author === null) {
                http_response_code(500);
                echo json_encode(['error' => "Author insert failed!"]);
            } else {
                http_response_code(200);
                echo json_encode($author);
            }
        } else {
            $response = $errors;
            $response['first_name'] = $first_name;
            $response['last_name'] = $last_name;

            http_response_code(400);
            echo json_encode($response);
        }
    }

    /**
     * Returns author edit form view. On error returns form view with errors.
     *
     * @param int $id - Id of the author to be edited.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processAuthorEdit(int $id): void
    {
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];

        $errors = $this->validateFormInput($first_name, $last_name);

        if (empty($errors)) {
            $author = $this->authorLogic->editAuthor($id, $first_name, $last_name);
            if ($author === null) {
                http_response_code(500);
                echo json_encode(['error' => "Author edit failed!"]);
            } else {
                http_response_code(200);
                echo json_encode($author);
            }
        } else {
            $response = $errors;

            $author = $this->authorLogic->fetchAuthor($id);
            $response['first_name'] = $author->getFirstname();
            $response['last_name'] = $author->getLastname();

            http_response_code(400);
            echo json_encode($response);
        }
    }

    /**
     * Renders author delete dialog.
     *
     * @param int $id - Id of author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function processAuthorDelete(int $id): void
    {
        if ($this->authorLogic->deleteAuthor($id)) {
            http_response_code(200);
            echo json_encode("Deletion successful!");
        } else {
            http_response_code(500);
            echo json_encode("Deletion failed!");
        }
    }

}