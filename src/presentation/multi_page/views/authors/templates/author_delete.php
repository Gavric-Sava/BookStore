<div class="wrapper wrapper-dialog">
    <div class="header">
        <img src="../../../../../../assets/images/alert.png"/>
        <h2>Delete Author</h2>
    </div>
    <div class="text">
        You are about to delete the author '<?php echo $author->getFirstname() . " " . $author->getLastname(); ?>'.
        If you proceed with this action Application will permanently delete all books related to this author.
    </div>
    <form method="post" class="buttons">
        <button type="submit" class="delete">Delete</button>
        <button type="button" class="cancel" onclick="history.back()">Cancel</button>
    </form>
</div>