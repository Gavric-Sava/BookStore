<div class="wrapper wrapper-list author-list">
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
                echo $template->render(
                    'authors/templates/author_item.php',
                    [
                        'author' => $author_with_book_count["author"],
                        'book_count' => $author_with_book_count["book_count"]
                    ]);
            }
        ?>
        </tbody>
    </table>
    <a href="/authors/create" class="create_link">
        <img src="<?php echo "../../../assets/images/create.png"; ?>" class="icon create"/>
    </a>
</div>