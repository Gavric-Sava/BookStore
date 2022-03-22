<?php

namespace Logeecom\Bookstore\presentation\util;

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
        require($_SERVER['DOCUMENT_ROOT'] . '/src/presentation/views/common/404.php');
    }

}