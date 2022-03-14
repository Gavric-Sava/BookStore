<?php

abstract class AuthorSessionRepository
{
    public static function initializeData(): void {
        $_SESSION["authors"] = [
            (new Author("Pera", "Peric", [0, 4])),
            (new Author("Mika", "Mikic", [1])),
            (new Author("Zika", "Zikic", [2])),
            (new Author("Nikola", "Nikolic", [3]))
        ];
    }

    public static function fetchAll(): array {
        return $_SESSION["authors"];
    }
}