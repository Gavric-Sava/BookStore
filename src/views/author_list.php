<table>
    <tr>
        <th>Author</th>
        <th>Books</th>
        <th>Actions</th>
    </tr>
    <?php
        foreach ($_SESSION["authors"] as $author) {
            echo "<tr>";
                echo "<td>";
                    echo $author->getFirstName() . " " . $author->getLastName();
                echo "</td>";
                echo "<td>";
                    echo $author->getBookCount();
                echo "</td>";
                echo "<td>";

                echo "</td>";
            echo "</tr>";
        }
    ?>
</table>
<a href="">Add author</a>
