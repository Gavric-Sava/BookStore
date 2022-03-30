<tr>
    <td class='first'>
        <?php echo $book->getTitle() . " " . $book->getYear(); ?>
    </td>
    <td class='last'>
        <a href='/authors/<?php echo $author_id; ?>/books/edit/<?php echo $book->getId(); ?>'>
            <img src='../../../../../../assets/images/edit.jpg' class='icon edit'/>
        </a>
        <a href='/authors/<?php echo $author_id; ?>/books/delete/<?php echo $book->getId(); ?>'>
            <img src='../../../../../../assets/images/delete.png' class='icon'/>
        </a>
    </td>
</tr>