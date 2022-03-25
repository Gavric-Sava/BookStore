<?php

namespace Logeecom\Bookstore\presentation\interfaces;

use Logeecom\Bookstore\presentation\util\validators\GeneralValidator;

abstract class BaseAuthorController implements ControllerInterface
{

    abstract public function process(string $path): void;

    abstract protected function processAuthorList(): void;

    abstract protected function processAuthorCreate(): void;

    abstract protected function processAuthorEdit(int $id): void;

    abstract protected function processAuthorDelete(int $id): void;

    /**
     * Validation of input form data_access for 'Author create' and 'Author edit' use cases.
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