<?php

namespace Logeecom\Bookstore\presentation\multi_page\controllers;

use Logeecom\Bookstore\business\logic\interfaces\AuthorLogicInterface;
use Logeecom\Bookstore\presentation\base_controllers\BaseAuthorController;
use Logeecom\Bookstore\presentation\multi_page\views\ViewTemplate;
use Logeecom\Bookstore\presentation\util\RequestUtil;

class MultiPageAuthorController extends BaseAuthorController
{
    /**
     * @var AuthorLogicInterface - Author business logic.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    private AuthorLogicInterface $authorLogic;

    /**
     * @var ViewTemplate - View template engine
     */
    private ViewTemplate $viewTemplate;

    public function __construct(
        AuthorLogicInterface $authorLogic,
        ViewTemplate $viewTemplate
    ) {
        $this->authorLogic = $authorLogic;
        $this->viewTemplate = $viewTemplate;
    }

    /**
     * Renders list of authors.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function renderAuthorList(): void
    {
        $authors_with_book_count = $this->authorLogic->fetchAllAuthorsWithBookCount();

        echo $this->viewTemplate->render(
            'template.php',
            [
                'head' => ($this->viewTemplate->render('authors/partials/author_list_head.html')),
                'content' => ($this->viewTemplate->render(
                    'authors/templates/author_list.php',
                    ['authors_with_book_count' => $authors_with_book_count]
                ))
            ]
        );
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
        $this->renderAuthorList();
    }

    /**
     * Renders author create form.
     *
     * @param array $errors - Form input errors.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function renderAuthorCreate(array $errors = []): void
    {
        echo $this->viewTemplate->render(
            'template.php',
            [
                'head' => ($this->viewTemplate->render('authors/partials/author_create_head.html')),
                'content' => ($this->viewTemplate->render(
                    'authors/templates/author_form.php',
                    array_merge(['function_label' => 'Create'], $errors)
                ))
            ]
        );
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
            $this->authorLogic->createAuthor($first_name, $last_name);
            header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
        } else {
            $this->renderAuthorCreate($errors);
        }
    }

    /**
     * Renders author edit form.
     *
     * @param int $id - Id of author.
     * @param array $errors - Form input errors.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function renderAuthorEdit(int $id, array $errors = []): void
    {
        $author = $this->authorLogic->fetchAuthor($id);
        if (!isset($author)) {
            RequestUtil::render404();
        } else {
            echo $this->viewTemplate->render(
                'template.php',
                [
                    'head' => ($this->viewTemplate->render('authors/partials/author_edit_head.html')),
                    'content' => ($this->viewTemplate->render(
                        'authors/templates/author_form.php',
                        array_merge(
                            [
                                'function_label' => 'Edit',
                                'first_name' => $author->getFirstname(),
                                'last_name' => $author->getLastname()
                            ],
                            $errors
                        )
                    ))
                ]
            );
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

        $errors = $this->validateFormInput(
            $first_name,
            $last_name
        );

        if (empty($errors)) {
            $this->authorLogic->editAuthor($id, $first_name, $last_name);
            header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
        } else {
            $this->renderAuthorEdit($id, $errors);
        }
    }

    /**
     * Renders author delete dialog.
     *
     * @param int $id - Id of author.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     */
    public function renderAuthorDelete(int $id): void
    {
        $author = $this->authorLogic->fetchAuthor($id);
        if (!isset($author)) {
            RequestUtil::render404();
        } else {
            echo $this->viewTemplate->render(
                'template.php',
                [
                    'head' => ($this->viewTemplate->render('authors/partials/author_delete_head.html')),
                    'content' => ($this->viewTemplate->render(
                        'authors/templates/author_delete.php',
                        ['author' => $author]
                    ))
                ]
            );
        }
    }

    /**
     * Returns author delete dialog view. On error returns 404 view.
     *
     * @param int $id - Id of the author to be deleted.
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public function processAuthorDelete(int $id): void
    {
        $this->authorLogic->deleteAuthor($id);

        header('Location: ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
    }

}