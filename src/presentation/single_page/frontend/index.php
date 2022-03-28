<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../../assets/styles/common.css"> <!-- TODO ovako ili sa php __DIR__? -->
    <link rel="stylesheet" href="../../../../assets/styles/dialog.css">
    <link rel="stylesheet" href="../../../../assets/styles/form.css">
    <link rel="stylesheet" href="../../../../assets/styles/list.css">
    <link rel="stylesheet" href="../../../../assets/styles/list_authors.css">
    <link rel="stylesheet" href="../../../../assets/styles/list_books.css">
    <link href='../../../../assets/images/edit.jpg' rel='preload' as='image'>
    <link href='../../../../assets/images/create.png' rel='preload' as='image'>
    <link href='../../../../assets/images/delete.png' rel='preload' as='image'>
    <link href='../../../../assets/images/alert.png' rel='preload' as='image'>
    <title>Bookstore</title>
</head>
<body>
    <div class="container">
    </div>
<script>
<?php
    //da php uopste ne pokrece se za dobijanje f
    echo file_get_contents(__DIR__ . '/common.js');
    echo file_get_contents(__DIR__ . '/author.js');
    echo file_get_contents(__DIR__ . '/book.js');
?>
</script>
</body>
</html>