<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/src/data/models/Author.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/src/data/models/Book.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/src/init.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/src/controllers/AuthorController.php";
    session_start();

    if (!isset($_SESSION["data_initialized"])) {
        initSessionData();
    }
?>
    <?php
//        echo $_SERVER['REQUEST_URI'];
//        if (isset($_SESSION["authors"]) && sizeof($_SESSION["authors"]) > 0) {
//            include($_SERVER['DOCUMENT_ROOT']."/src/views/author_list.php");
//        }

        $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // TODO parse path...
//        print_r($request_path);

        switch ($request_path) {
            case '/':
            case '':
            case '/authors':
                (new AuthorController())->process($request_path);
                break;
            default:
                http_response_code(404);
                require ($_SERVER['DOCUMENT_ROOT']."/src/views/404.php");
        }
    ?>
<!--    <h1>Book list</h1>-->
<!--    --><?php
//        if (isset($_SESSION["books"]) && sizeof($_SESSION["books"]) > 0) {
//            include($_SERVER['DOCUMENT_ROOT']."/src/views/book_list.php");
//        }
//    ?>
</body>
</html>
