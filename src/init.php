<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/src/models/Author.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/src/models/Book.php";

    function initSessionData() {
        $_SESSION["authors"] = [
            (new Author("Pera", "Peric", [0, 4])),
            (new Author("Mika", "Mikic", [1])),
            (new Author("Zika", "Zikic", [2])),
            (new Author("Nikola", "Nikolic", [3]))
        ];

        $_SESSION["books"] = [
            (new Book("Book Name", 2001)),
            (new Book("Book Name 1", 2002)),
            (new Book("Book Name 2", 1997)),
            (new Book("Book Name 3", 2005)),
            (new Book("Book Name 4", 2006))
        ];

//        $_SESSION["pera"] = serialize(new Author("Pera", "Peric"));

        $_SESSION["data_initialized"] = true;
    }