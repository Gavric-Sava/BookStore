<div class="wrapper wrapper-list book-list">
    <h1>Book list</h1>
    <table>
        <col class="first-column">
        <col class="second-column last">
        <thead>
        <tr>
            <th class="first">Book</th>
            <th class="last">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($books as $book) {
            echo $template->render(
                'books/templates/book_item.php',
                [
                    'book' => $book,
                    'author_id' => $author_id
                ]);
        }
        ?>
        </tbody>
    </table>
    <a href="/authors/<?php echo $author_id; ?>/books/create" class="create_link">
        <img src="<?php echo "../../../assets/images/create.png"; ?>" class='icon create'/>
    </a>
</div>