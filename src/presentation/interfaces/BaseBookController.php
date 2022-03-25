<?php

namespace Logeecom\Bookstore\presentation\interfaces;

use Logeecom\Bookstore\presentation\util\validators\GeneralValidator;

abstract class BaseBookController implements ControllerInterface
{
    /**
     * @inheritDoc
     */
    abstract public function process(string $path): void;

    /**
     * Processes book list request.
     * @param int $author_id - Id of book author.
     * @return void
     */
    abstract protected function processBookList(int $author_id): void;

    /**
     * Processes book create request.
     * @param int $author_id - Id of book author.
     * @return void
     */
    abstract protected function processBookCreate(int $author_id): void;

    /**
     * Processes book edit request.
     * @param int $id - Id of book.
     * @return void
     */
    abstract protected function processBookEdit(int $id): void;

    /**
     * Processes book delete request.
     * @param int $id - Id of book.
     * @return void
     */
    abstract protected function processBookDelete(int $id): void;

    /**
     * Validation of input form data_access for 'Book create' and 'Book edit' use cases.
     *
     * @param mixed $title Title of the book to be created/edited.
     * @param mixed $year Year of the book to be created/edited.
     * @return string[]|null List of errors or null, if no errors occurred.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected static function validateFormInput($title, $year): array
    {
        $errors = [];

        if (!GeneralValidator::validateNotEmpty($title)) {
            $errors['title_error'] = 'Title is required.';
        } else {
            $title = GeneralValidator::sanitizeData($title);
            if (!GeneralValidator::validateAlphanumeric($title)) {
                $errors['title_error'] = 'Title is not in a valid format.';
            }
        }

        if (!GeneralValidator::validateNotEmpty($year)) {
            $errors['year_error'] = 'Year is required.';
        } else {
            $year = GeneralValidator::sanitizeData($year);
            if (!GeneralValidator::validateNumber($year)) {
                $errors['year_error'] = 'Year is not in a valid format.';
            }
        }

        return $errors;
    }
}