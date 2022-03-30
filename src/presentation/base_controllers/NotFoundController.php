<?php

namespace Logeecom\Bookstore\presentation\base_controllers;

use Logeecom\Bookstore\presentation\multi_page\views\ViewTemplate;

class NotFoundController
{

    private ViewTemplate $viewTemplate;

    public function __construct(ViewTemplate $viewTemplate)
    {
        $this->viewTemplate = $viewTemplate;
    }

    public function render404(): void
    {
        echo $this->viewTemplate->render(
            'template.php',
            [
                'head' => $this->viewTemplate->render('common/partials/404_head.html'),
                'content' => $this->viewTemplate->render('common/templates/404.php')
            ]
        );
    }
}