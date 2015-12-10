<?php include DOC_ROOT.'includes/header.php';?>
<div class="container errorPage">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
                <h1>Oops!</h1>
                <h2>An error has occured.</h2>
                <div class="alert alert-danger" role="alert">
                    <p><?php echo $this->getMessage(); ?></p>
                </div>
                <?php
                    if (preg_match('/^(.*)Access denied for user (.*)/s', $this->getMessage(), $matches)):
                        include DOC_ROOT.'includes/html/db-create-user-help.html';
                        include DOC_ROOT.'includes/html/db-structure-help.html';
                        include DOC_ROOT.'includes/html/db-tuning.html';
                        include DOC_ROOT.'includes/html/delete-files-help.html';
                    elseif (preg_match('/^Database (.*) not found/', $this->getMessage(), $matches)):
                            include DOC_ROOT.'includes/html/db-database-help.html';
                            include DOC_ROOT.'includes/html/db-structure-help.html';
                            include DOC_ROOT.'includes/html/db-tuning.html';
                            include DOC_ROOT.'includes/html/delete-files-help.html';
                    endif;
                ?>
            </div> <!-- end of .jumbotron -->
        </div>
    </div>
</div>
<?php include DOC_ROOT.'includes/footer.php';