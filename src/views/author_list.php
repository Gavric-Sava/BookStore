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
    <table>
        <tr>
            <th class='frst_col'>Author</th>
            <th>Books</th>
            <th>Actions</th>
        </tr>
        <?php
            foreach ($authors as $author) {
                echo "<tr>";
                    echo "<td class='frst_col'>";
                        echo $author->getFirstName() . " " . $author->getLastName();
                    echo "</td>";
                    echo "<td>";
                        echo $author->getBookCount();
                    echo "</td>";
                    echo "<td>";
                        echo "<a href=''>"."<img src='../../assets/images/edit.jpg' class='img_link'/>"."</a>";
                        echo "<a href=''>"."<img src='../../assets/images/delete.png' class='img_link'/>"."</a>";
                    echo "</td>";
                echo "</tr>";
            }
        ?>
    </table>
    <a href="">
        <img src="<?php echo "../../assets/images/add.png"; ?>" class='img_link'/>
    </a>
</body>
</html>