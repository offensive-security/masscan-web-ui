<?php include DOC_ROOT.'includes/header.php';?>
    <div class="container errorPage">
        <div class="row">
            <div class="col-md-12">
                <div class="jumbotron">
                    <h2>Setup MASSCAN WEB UI</h2>
                    <?php
                        if (!extension_loaded('simplexml')) {
                            ?>
                                <div class="alert alert-danger">
                                    <p><i class="glyphicon glyphicon-info-sign"></i> PHP-XML package is missing!</p>
                                    <p>To install PHP_XML package on Kali linux type:</p>
                                    <pre class="shell">
root@kali:~# sudo apt-get install php-xml
                                    </pre>
                                    <p>Don't forget to restart webserver after installing.</p>
                                </div>
                            <?php
                        }
                        if (!extension_loaded('pdo') ) {
                            ?>
                            <div class="alert alert-danger">
                                <p><i class="glyphicon glyphicon-info-sign"></i> PHP-PDO package is missing!</p>
                                <p>To install PHP_PDO package on Kali linux type:</p>
                                <pre class="shell">
root@kali:~# sudo apt-get install php-pdo
                                    </pre>
                                <p>Don't forget to restart webserver after installing.</p>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="alert alert-danger">
                            <h4><i class="glyphicon glyphicon-exclamation-sign"></i> Error message</h4>
                            <p><?php echo $pdoe->getMessage ();?>.</p>
                        </div>
                    <p>It's easy and fast. Just follow instructions and setup will be done in a few minutes.</p>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="<?php if (DB_DRIVER !== 'pgsql') echo 'active'; ?>"><a href="#mysql" aria-controls="home" role="tab" data-toggle="tab">MySQL</a></li>
                        <li role="presentation" class="<?php if (DB_DRIVER == 'pgsql') echo 'active'; ?>"><a href="#pgsql" aria-controls="profile" role="tab" data-toggle="tab">PostgreSQL</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane<?php if (DB_DRIVER !== 'pgsql') echo ' active'; ?>" id="mysql">
                            <br>
                            <p>Make sure that you have installed php-mysqli package. If not, open terminal and type:</p>
                            <pre class="shell">
root@kali:~# apt-get install php-mysqli
</pre>
                            <p>Than go to the document root of application by typing:</p>
                            <pre class="shell">
root@kali:~# cd <?php echo DOC_ROOT;?>
</pre>
                            <p>Edit config.php and provide MySql host, user, password and database information. Type:</p>
                            <pre class="shell">
root@kali:<?php echo DOC_ROOT;?># nano config.php
</pre>
                            <p>and change the default values if necessary:</p>
                            <pre>
define('DB_DRIVER',     'mysql');
define('DB_HOST',       '<?php echo DB_HOST;?>');
define('DB_USERNAME',	'<?php echo DB_USERNAME;?>');
define('DB_PASSWORD', 	'<?php echo DB_PASSWORD;?>');
define('DB_DATABASE', 	'<?php echo DB_DATABASE;?>');
</pre>
                            <p class="alert alert-info">If you change default database params in config.php before you continue with setup, in order for the changes to take effect refresh this page (press F5 or click <a href="./">here</a>) and you will have updated all commands later in this page.</p>
                            <p>Next step is to login to MySql and create the database:</p>
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
                            <p>When you finished with all the above, you can continue with installation by pressing F5 or clicking <a href="./">here</a>.</p>
                        </div>
                        <div role="tabpanel" class="tab-pane<?php if (DB_DRIVER == 'pgsql') echo ' active'; ?>" id="pgsql">
                            <br>
                            <p>Make sure that you have installed php-pgsql package. If not, open terminal and type:</p>
                            <pre class="shell">
root@kali:~# apt-get install php-pgsql
</pre>
                            <p>Than go to application document root:</p>
                            <pre class="shell">
root@kali:~# cd <?php echo DOC_ROOT;?>
</pre>
                            <p>Edit config.php and provide PostgreSQL host, user, password and database information. Type:</p>
                            <pre class="shell">
root@kali:<?php echo DOC_ROOT;?># nano config.php
</pre>
                            <p>and change the default values if necessary:</p>
                            <pre>
define('DB_DRIVER',     'pgsql');
define('DB_HOST',       '<?php echo DB_HOST;?>');
define('DB_USERNAME',	'<?php echo DB_USERNAME;?>');
define('DB_PASSWORD', 	'<?php echo DB_PASSWORD;?>');
define('DB_DATABASE', 	'<?php echo DB_DATABASE;?>');
</pre>
                            <p class="alert alert-info">If you change default database params in config.php before you continue with setup, in order for the changes to take effect refresh this page (press F5 or click <a href="./">here</a>) and you will have updated all commands later in this page.</p>
                            <p>Next step is to login to PostgreSQL and create user and database :</p>
                            <pre class="shell">
root@kali:<?php echo DOC_ROOT;?># su postgres
postgres@kali:/home$
</pre>
                            <p>Than log into PostgreSQL server:</p>
                            <pre class="shell">
root@kali:/home$ psql
psql (9.5.7)
Type "help" for help.
postgres=#
</pre>
                            <p>Now, create new user:</p>
<pre class="shell">
postgres=# create user masscan;
CREATE ROLE
postgres=#
</pre>
<p>Generate password for newly create user:</p>
                            <pre class="shell">
postgres=# alter user masscan with password 'changem3';
ALTER ROLE
</pre>
                            <p>Now create database:</p>
                            <pre class="shell">
postgres=# create database masscan;
CREATE DATABASE
</pre>
                            <p>and finally add permissions:.</p>
                            <pre class="shell">
postgres=# grant all privileges on database masscan to masscan;
GRANT
</pre>
                            <p>Finally, exit PostgreSQL:</p>
                            <pre class="shell">
postgres=# \q
postgres@kali:/home$ exit
root@kali:/home$
</pre>
                            <p>and refresh this page.</p>
                        </div>
                    </div>
                </div> <!-- end of .jumbotron -->
            </div> <!-- end .col-md-12 -->
        </div> <!-- end of .row -->
    </div> <!-- end of .container -->
<?php include DOC_ROOT.'includes/footer.php';
