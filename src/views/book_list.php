<table>
    <th>
        <td>Book</td>
        <td>Actions</td>
    </th>
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