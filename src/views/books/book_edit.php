<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../assets/styles/form.css">
    <title>Edit book</title>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <span>Book Edit (<?php echo $book->getId(); ?>)</span>
    </div>
    <form method="post">
        <div class="form-item">
            <span>Title</span>
            <input type="text" name="title" value="<?php echo $book->getTitle(); ?>">
            <span class="error"><?php echo $title_error; ?></span>
        </div>
        <div class="form-item">
            <span>Year</span>
            <input type="text" name="year" value="<?php echo $book->getYear(); ?>">
            <span class="error"><?php echo $year_error; ?></span>
        </div>
        <div class="button">
            <button name="submit">Save</button>
        </div>
    </form>
</div>
</body>
</html>