<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/src/models/Author.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/src/models/Book.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/src/init.php";
    session_start();

    if (!isset($_SESSION["data_initialized"])) {
        initSessionData();
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo "./assets/styles/list.css"?>">
    <title>BookStore</title>
</head>
<body>
    <h1>Author list</h1>
    <?php
//        echo parse_url($_SERVER['REQUEST_URI']);
        if (isset($_SESSION["authors"]) && sizeof($_SESSION["authors"]) > 0) {
            include($_SERVER['DOCUMENT_ROOT']."/src/views/author_list.php");
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
