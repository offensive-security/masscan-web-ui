<?php include DOC_ROOT.'includes/header.php';?>
<div class="container errorPage">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
                <h1>Oops!</h1>
                <h2>An error has occured.</h2>
                <div class="alert alert-danger" role="alert">
                    <p><?php echo htmlentities($this->getMessage()); ?></p>
                </div>
                <p>Check <a href="https://github.com/offensive-security/masscan-web-ui#readme" target="_blank">read me</a> file for help.</p>
            </div>
        </div>
    </div>
</div>
<?php include DOC_ROOT.'includes/footer.php';