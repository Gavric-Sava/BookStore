<div class="wrapper wrapper-form">
    <div class="header">
        <span>Author
            <?php
                echo $function_label;
                if (isset($author)) {
                    echo '(' . $author->getId() . ')';
                }
            ?>
        </span>
    </div>
    <form method="post">
        <div class="form-item">
            <span>First name</span>
            <input type="text" name="first_name" value="<?php echo $first_name; ?>">
            <span class="error"><?php echo $first_name_error; ?></span>
        </div>
        <div class="form-item">
            <span>Last name</span>
            <input type="text" name="last_name" value="<?php echo $last_name; ?>">
            <span class="error"><?php echo $last_name_error; ?></span>
        </div>
        <div class="button">
            <input type="submit" name="submit" value="Save">
        </div>
    </form>
</div>