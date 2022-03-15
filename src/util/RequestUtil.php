<?php

abstract class RequestUtil
{
    public static function render404(): void
    {
        http_response_code(404);
        require($_SERVER['DOCUMENT_ROOT'] . '/src/views/404.php');
    }
}