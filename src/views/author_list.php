<table>
    <th>
        <td>Author</td>
        <td>Books</td>
        <td>Actions</td>
    </th>
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
