<?php

namespace Logeecom\Bookstore\presentation\multi_page\views;

class ViewTemplate
{

    private string $path;
    private array $parameters;

    /**
     * ViewTemplate constructor.
     * @param string $path
     * @param array $parameters
     *
     */
    public function __construct(string $path, array $parameters = [])
    {
        $this->path = rtrim($path, '/').'/';
        $this->parameters = $parameters;
    }

    public function render(string $view, array $context = []): string
    {
        $file = $this->path.$view;

        extract(array_merge($context, ['template' => $this]));

        ob_start();
        include ($file);
        return ob_get_clean();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->parameters[$key] ?? null;
    }
}