<?php

namespace Logeecom\Bookstore\presentation\interfaces;

interface RouterInterface
{
    public function route(string $request_path): void;
}