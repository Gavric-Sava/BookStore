<?php

namespace Logeecom\Bookstore\util;

abstract class RequestUtil
{
    /**
     * Render 404 - Page not found view.
     *
     * @return void
     * @author Sava Gavric <sava.gavric@logeecom.com>
     *
     */
    public static function render404(): void
    {
        http_response_code(404);
        require($_SERVER['DOCUMENT_ROOT'] . '/src/views/common/404.php');
    }

    /**
     * Trim excess white space and escape html elements to prevent HTML injection.
     * @param $data mixed to be sanitized.
     * @return mixed Sanitized data
     */
    public static function sanitizeData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    /**
     * Check if input data is empty.
     * @param $data mixed to be checked.
     * @return bool Result of the check.
     */
    public static function validateNotEmpty($data): bool
    {
        return !empty($data);
    }

    /**
     * Check if input data is an alphabetical string.
     * @param $data mixed to be checked.
     * @return bool Result of the check.
     */
    public static function validateAlphabetical($data): bool
    {
        return preg_match('/^(?:[a-zA-Z]|\s){1,100}$/', $data);
    }

    /**
     * Check if input data is an alphanumeric string.
     * @param $data mixed to be checked.
     * @return bool Result of the check.
     */
    public static function validateAlphanumeric($data): bool
    {
        return preg_match('/^(?:[a-zA-Z]|\s|\d){1,100}$/', $data);
    }

    /**
     * Check if input data is a number.
     * @param $data mixed to be checked.
     * @return bool Result of the check.
     */
    public static function validateNumber($data): bool
    {
        return preg_match('/^\d{1,4}$/', $data);
    }
}