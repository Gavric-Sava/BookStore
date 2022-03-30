<div class="wrapper wrapper-form">
    <div class="header">
        <span>Book
            <?php
                echo $function_label;
                if (isset($book)) {
                    echo '(' . $book->getId() . ')';
                }
            ?>
        </span>
    </div>
    <form method="post">
        <div class="form-item">
            <span>Title</span>
            <input type="text" name="title" value="<?php echo $title; ?>">
            <span class="error"><?php echo $title_error; ?></span>
        </div>
        <div class="form-item">
            <span>Year</span>
            <input type="text" name="year" value="<?php echo $year; ?>">
            <span class="error"><?php echo $year_error; ?></span>
        </div>
        <div class="button">
            <input type="submit" name="submit" value="Save">
        </div>
    </form>
</div>