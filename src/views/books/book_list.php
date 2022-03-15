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
        <h1>Book list</h1>
        <table>
            <col class="first-column">
            <col class="second-column">
            <col class="third-column">
            <thead>
                <tr>
                    <th>Book</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($books as $book) {
                        echo "<tr>";
                            echo "<td>";
                                echo $book->getName()." ".$book->getYear();
                            echo "</td>";
                            echo "<td>";
                                echo "<a href='".'/books/edit/'.$book->getId()."'>".
                                    "<img src='../../../assets/images/edit.jpg' class='icon edit'/>" .
                                "</a>";
                                echo "<a href='".'/books/delete/'.$book->getId()."'>".
                                    "<img src='../../../assets/images/delete.png' class='icon'/>" .
                                "</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <a href="/books/create" class="create_link">
            <img src="<?php echo "../../assets/images/create.png"; ?>" class='icon'/>
        </a>
    </div>
</body>
</html>