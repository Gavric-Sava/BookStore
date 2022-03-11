<table>
    <tr>
        <th>Book</th>
        <th>Actions</th>
    </tr>
    <?php
        foreach ($_SESSION["books"] as $book) {
            echo "<tr>";
                echo "<td>";
                    echo $book->getName() . " " . $book->getYear();
                echo "</td>";
                echo "<td>";
                    // TODO
                echo "</td>";
            echo "</tr>";
        }
    ?>
</table>