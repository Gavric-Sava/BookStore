<?php

namespace Logeecom\Bookstore\presentation\util\validators;

class GeneralValidator
{
    /**
     * Trim excess white space and escape html elements to prevent HTML injection.
     * @param $data mixed to be sanitized.
     * @return mixed Sanitized data_access
     */
    public static function sanitizeData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    /**
     * Check if input data_access is empty.
     * @param $data mixed to be checked.
     * @return bool Result of the check.
     */
    public static function validateNotEmpty($data): bool
    {
        return !empty($data);
    }

    /**
     * Check if input data_access is an alphabetical string.
     * @param $data mixed to be checked.
     * @return bool Result of the check.
     */
    public static function validateAlphabetical($data): bool
    {
        return preg_match('/^(?:[a-zA-Z]|\s){1,100}$/', $data);
    }

    /**
     * Check if input data_access is an alphanumeric string.
     * @param $data mixed to be checked.
     * @return bool Result of the check.
     */
    public static function validateAlphanumeric($data): bool
    {
        return preg_match('/^(?:[a-zA-Z]|\s|\d){1,100}$/', $data);
    }

    /**
     * Check if input data_access is a number.
     * @param $data mixed to be checked.
     * @return bool Result of the check.
     */
    public static function validateNumber($data): bool
    {
        return preg_match('/^\d{1,4}$/', $data);
    }
}