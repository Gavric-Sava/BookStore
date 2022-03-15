<?php

abstract class RequestUtil
{
    public static function render404(): void
    {
        http_response_code(404);
        require($_SERVER['DOCUMENT_ROOT'] . '/src/views/common/404.php');
    }

    public static function cleanData($data)
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
        return preg_match('/^[a-zA-Z]{1,100}$/', $data);
    }
}