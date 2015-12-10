<?php include DOC_ROOT.'includes/header.php';?>
    <div class="container errorPage">
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron">
                    <h2>Setup MASSCAN WEB UI</h2>
                    <p>It's easy and fast. Just follow instructions and setup will be done in a few minutes.</p>
                    <p>Open terminal and go to the document root of application by typing:</p>
<pre class="shell">
root@kali:~# cd <?php echo DOC_ROOT;?>
</pre>
                    <p>Edit config.php and update the file with MySql host, user, password and database information. Type:</p>
<pre class="shell">
root@kali:<?php echo DOC_ROOT;?># nano config.php
</pre>
                    <p>and change the default values if necessary:</p>
<pre>
define('DB_HOST',       '<?php echo DB_HOST;?>');
define('DB_USERNAME',	'<?php echo DB_USERNAME;?>');
define('DB_PASSWORD', 	'<?php echo DB_PASSWORD;?>');
define('DB_DATABASE', 	'<?php echo DB_DATABASE;?>');
</pre>
                    <p class="alert alert-info">If you change default database params in config.php before you continue with setup, in order for the changes to take effect refresh this page (press F5 or click <a href="/">here</a>) and you will have updated all commands later in this page.</p>
                    <p>Next step is to login to MySql as root by executing following command:</p>
<pre class="shell">
root@kali:<?php echo DOC_ROOT;?># mysql -u root -p
Enter password:
Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.
mysql>
</pre>
                    <p>Create the database by executing following command:</p>
<pre class="shell">
mysql> create database <?php echo DB_DATABASE;?>;
Query OK, 1 row affected (0.01 sec)
</pre>
                    <p>Now create new user:</p>
<pre class="shell">
mysql> CREATE USER '<?php echo DB_USERNAME;?>'@'<?php echo DB_HOST;?>' IDENTIFIED BY '<?php echo DB_PASSWORD;?>';
Query OK, 0 rows affected (0.00 sec)
</pre>
                    <p>Give the newly created user <strong><?php echo DB_USERNAME;?></strong> privileges for database <strong><?php echo DB_DATABASE;?></strong>:</p>
<pre class="shell">
mysql> GRANT ALL PRIVILEGES ON <?php echo DB_DATABASE;?>.* TO '<?php echo DB_USERNAME;?>'@'<?php echo DB_HOST;?>';
Query OK, 0 rows affected (0.01 sec)
</pre>
                    <p>Finally quit MySql by typing:</p>
<pre class="shell">
mysql> exit
Bye
</pre>
                    <p>and you are done.</p>
                    <p>When you finished with all the above, you can continue with installation by pressing F5 or clicking <a href="/">here</a>.</p>
                </div> <!-- end of .jumbotron -->
            </div> <!-- end .col-md-12 -->
        </div> <!-- end of .row -->
    </div> <!-- end of .container -->
<?php include DOC_ROOT.'includes/footer.php';
