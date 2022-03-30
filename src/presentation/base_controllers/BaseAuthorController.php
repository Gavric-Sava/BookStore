<?php

namespace Logeecom\Bookstore\presentation\base_controllers;

use Logeecom\Bookstore\presentation\util\GeneralValidator;

abstract class BaseAuthorController
{

    /**
     * Process author list request.
     * @return void
     */
    abstract protected function processAuthorList(): void;

    /**
     * Process author create request.
     * @return void
     */
    abstract protected function processAuthorCreate(): void;

    /**
     * Process author edit request.
     * @param int $id - Id of author.
     * @return void
     */
    abstract protected function processAuthorEdit(int $id): void;

    /**
     * Process author delete request.
     * @param int $id - Id of author.
     * @return void
     */
    abstract protected function processAuthorDelete(int $id): void;

    /**
     * Validate input form data_access for 'Author create' and 'Author edit' use cases.
     *
     * @param mixed $first_name First name of the author to be created/edited.
     * @param mixed $last_name Last name of the author to be created/edited.
     * @return string[]|null List of errors or null, if no errors occurred.
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    protected function validateFormInput($first_name, $last_name): array
    {
        $errors = [];

        if (!GeneralValidator::validateNotEmpty($first_name)) {
            $errors["first_name_error"] = 'First name is required.';
        } else {
            $first_name = GeneralValidator::sanitizeData($first_name);
            if (!GeneralValidator::validateAlphabetical($first_name)) {
                $errors["first_name_error"] = 'First name is not in a valid format.';
            }
        }

        if (!GeneralValidator::validateNotEmpty($last_name)) {
            $errors["last_name_error"] = 'Last name is required.';
        } else {
            $last_name = GeneralValidator::sanitizeData($last_name);
            if (!GeneralValidator::validateAlphabetical($last_name)) {
                $errors["last_name_error"] = 'Last name is not in a valid format.';
            }
        }

        return $errors;
    }

}