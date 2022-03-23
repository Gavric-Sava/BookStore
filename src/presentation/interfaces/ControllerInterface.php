<?php

namespace Logeecom\Bookstore\presentation\interfaces;

interface ControllerInterface
{
    public function process(string $path): void;
}