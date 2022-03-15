<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../assets/styles/list.css">
    <title>BookStore</title>
</head>
<body>
    <div class="wrapper">
        <h1>Author list</h1>
        <table>
            <col class="first-column">
            <col class="second-column">
            <col class="third-column">
            <thead>
                <tr>
                    <th>Author</th>
                    <th>Books</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($authors as $author) {
                        echo "<tr>";
                            echo "<td>";
                                echo $author->getFirstName()." ".$author->getLastName();
                            echo "</td>";
                            echo "<td>";
                                echo $author->getBookCount();
                            echo "</td>";
                            echo "<td>";
                                echo "<a href='".'/authors/edit/'.$author->getId()."'>".
                                    "<img src='../../../assets/images/edit.jpg' class='icon edit'/>" .
                                "</a>";
                                echo "<a href='".'/authors/delete/'.$author->getId()."'>".
                                    "<img src='../../../assets/images/delete.png' class='icon'/>" .
                                "</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <a href="/authors/create" class="create_link">
            <img src="<?php echo "../../assets/images/create.png"; ?>" class="icon"/>
        </a>
    </div>
</body>
</html>