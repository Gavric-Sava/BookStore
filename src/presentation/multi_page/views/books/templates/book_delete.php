<div class="wrapper wrapper-dialog">
    <div class="header">
        <img src="../../../../../../assets/images/alert.png"/>
        <h2>Delete Book</h2>
    </div>
    <div class="text">
        You are about to delete the book '<?php echo $book->getTitle() . "(" . $book->getYear() . ")"; ?>'.
    </div>
    <form method="post" class="buttons">
        <button type="submit" class="delete">Delete</button>
        <button type="button" class="cancel" onclick="history.back()">Cancel</button>
    </form>
</div>