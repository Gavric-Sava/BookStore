<?php

namespace Bookstore\Util;

abstract class RequestUtil
{
    public static function render404(): void
    {
        http_response_code(404);
        require($_SERVER['DOCUMENT_ROOT'] . '/src/views/common/404.php');
    }

    public static function sanitizeData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    public static function validateNotEmpty($data): bool
    {
        return !empty($data);
    }

    public static function validateAlphabetical($data): bool
    {
        return preg_match('/^(?:[a-zA-Z]|\s){1,100}$/', $data);
    }

    public static function validateAlphanumeric($data): bool
    {
        return preg_match('/^(?:[a-zA-Z]|\s|\d){1,100}$/', $data);
    }

    public static function validateNumber($data): bool
    {
        return preg_match('/^\d{1,4}$/', $data);
    }
}