<table>
    <tr>
        <th class='frst_col'>Author</th>
        <th>Books</th>
        <th>Actions</th>
    </tr>
    <?php
        foreach ($_SESSION["authors"] as $author) {
            echo "<tr>";
                echo "<td class='frst_col'>";
                    echo $author->getFirstName() . " " . $author->getLastName();
                echo "</td>";
                echo "<td>";
                    echo $author->getBookCount();
//                    echo $author->getBooks()[0];
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
