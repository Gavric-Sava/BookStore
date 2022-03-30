<tr>
    <td class='first'>
        <a href="/authors/<?php echo $author->getId(); ?>/books">
            <?php echo $author->getFirstName() . " " . $author->getLastName() ?>
        </a>
    </td>
    <td class='books'>
        <?php echo $book_count; ?>
    </td>
    <td class='last'>
        <a href='/authors/edit/<?php echo $author->getId() ?>'>
            <img src='../../../../../../assets/images/edit.jpg' class='icon edit'/>
        </a>
        <a href='/authors/delete/<?php echo $author->getId() ?>'>
            <img src='../../../../../../assets/images/delete.png' class='icon'/>
        </a>
    </td>
</tr>