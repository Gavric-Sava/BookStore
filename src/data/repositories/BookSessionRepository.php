<?php

abstract class BookSessionRepository
{
    public static function initializeData(): void {
        $_SESSION["books"] = [
            (new Book("Book Name", 2001)),
            (new Book("Book Name 1", 2002)),
            (new Book("Book Name 2", 1997)),
            (new Book("Book Name 3", 2005)),
            (new Book("Book Name 4", 2006))
        ];
    }

    public static function fetchAll(): array {
        return $_SESSION["books"];
    }
}