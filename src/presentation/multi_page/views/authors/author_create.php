<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../../../assets/styles/common.css">
    <link rel="stylesheet" href="../../../../../assets/styles/form.css">
    <title>Create author</title>
</head>
<body>
    <div class="container">
        <div class="wrapper wrapper-form">
            <div class="header">
                <span>Author Create</span>
            </div>
            <form method="post">
                <div class="form-item">
                    <span>First name</span>
                    <input type="text" name="first_name" value="<?php echo $first_name; ?>">
                    <span class="error"><?php echo $first_name_error; ?></span>
                </div>
                <div class="form-item">
                    <span>Last name</span>
                    <input type="text" name="last_name" value="<?php echo $last_name; ?>">
                    <span class="error"><?php echo $last_name_error; ?></span>
                </div>
                <div class="button">
                    <input type="submit" name="submit" value="Save">
                </div>
            </form>
        </div>
    </div>
</body>
</html>