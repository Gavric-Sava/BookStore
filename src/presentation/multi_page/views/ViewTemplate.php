<?php

namespace Logeecom\Bookstore\presentation\multi_page\views;

class ViewTemplate
{

    /**
     * @var string - Directory path.
     */
    private string $path;
    /**
     * @var array - View parameters.
     */
    private array $parameters;

    /**
     * @param string $path - Directory path.
     * @param array $parameters - View parameters.
     */
    public function __construct(string $path, array $parameters = [])
    {
        $this->path = rtrim($path, '/') . '/';
        $this->parameters = $parameters;
    }

    /**
     * Render given template file with its context.
     * @param string $view - Template file.
     * @param array $context - Parameters for rendering.
     * @return string
     */
    public function render(string $view, array $context = []): string
    {
        $file = $this->path . $view;

        extract(array_merge($context, ['template' => $this]));

        ob_start();
        include($file);
        return ob_get_clean();
    }

    /**
     * @param string $key - Key of parameter array element.
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->parameters[$key] ?? null;
    }
}