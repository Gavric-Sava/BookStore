<?php

namespace Bookstore\Controller;

abstract class BaseController
{
    public abstract function process(string $path);
}