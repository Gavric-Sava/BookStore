<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../../../../assets/styles/list.css">
    <link rel="stylesheet" href="../../../../../assets/styles/list_authors.css">
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
                    <th class='first'>Author</th>
                    <th class="books">Books</th>
                    <th class="last">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($authors_with_book_count as $author_with_book_count) {
                        echo "<tr>";
                            echo "<td class='first'>";
                                echo $author_with_book_count["author"]->getFirstName()." ".
                                    $author_with_book_count["author"]->getLastName();
                            echo "</td>";
                            echo "<td class='books'>";
                                echo $author_with_book_count["book_count"];
                            echo "</td>";
                            echo "<td class='last'>";
                                echo "<a href='".'/authors/edit/'.$author_with_book_count["author"]->getId()."'>".
                                    "<img src='../../../../../assets/images/edit.jpg' class='icon edit'/>" .
                                "</a>";
                                echo "<a href='".'/authors/delete/'.$author_with_book_count["author"]->getId()."'>".
                                    "<img src='../../../../../assets/images/delete.png' class='icon'/>" .
                                "</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
        <a href="/authors/create" class="create_link">
            <img src="<?php echo "../../assets/images/create.png"; ?>" class="icon create"/>
        </a>
    </div>
</body>
</html>