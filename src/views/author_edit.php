<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit author</title>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <span>Author Edit (<?php echo $author->getId(); ?>)</span>
        </div>
        <form>
            <div class="form">
                <div class="form-item">
                    <span>First name</span>
                    <input type="text" name="first_name">
                </div>
                <div class="form-item">
                    <span>Last name</span>
                    <input type="text" name="last_name">
                </div>
            </div>
            <div class="button">
                <button name="submit">Save</button>
            </div>
        </form>
    </div>
</body>
</html>