<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../../../assets/styles/dialog.css">
    <title>Delete book</title>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <img src="../../../../../assets/images/alert.png"/>
        <h2>Delete Book</h2>
    </div>
    <div class="text">
        You are about to delete the book '<?php echo $book->getTitle() . "(" . $book->getYear() . ")"; ?>'.
    </div>
    <form method="post" class="buttons">
        <button type="submit" class="delete">Delete</button>
        <button type="button" class="cancel" onclick="javascript:history.back()">Cancel</button>
    </form>
</div>
</body>
</html>