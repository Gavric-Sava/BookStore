<table>
    <tr>
        <th class='frst_col'>Book</th>
        <th>Actions</th>
    </tr>
    <?php
        foreach ($_SESSION["books"] as $book) {
            echo "<tr>";
                echo "<td class='frst_col'>";
                    echo $book->getName() . " " . $book->getYear();
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