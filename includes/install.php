<?php include DOC_ROOT.'includes/header.php';?>
<div class="container errorPage">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron">
                <h2>Installing db tables</h2>
                <p>Installer will try to automatically execute required db queries for creating necessary tables.</p>
                <?php
                if (is_file(DOC_ROOT.'db-structure.sql') && is_readable(DOC_ROOT.'db-structure.sql')):
                    $sql = file_get_contents(DOC_ROOT.'db-structure.sql');
                    $queries = explode(";", trim(trim($sql), ";"));
                    if (!empty($queries)):
                        $error = false;
                        foreach ($queries as $q):
                            if (!DB::query($q, false)):
                                $error = true;
                                break;
                            endif;
                        endforeach;
                        if ($error): ?>
                            <p class="alert alert-danger"><i class="glyphicon glyphicon-remove"></i> Installation failed, queries not executed.</p>
                            <p>To manually install required tables, open terminal and go to the document root by executing following command:</p>
                            <pre class="shell">
root@kali:~# cd <?php echo DOC_ROOT; ?>
                            </pre>
                            <p>To execute necessary queries, execute following command:</p>
                            <pre class="shell">
root@kali:<?php echo DOC_ROOT; ?># mysql -u <?php echo DB_USERNAME;?> -p <?php echo DB_DATABASE;?> < db-structure.sql
</pre>
                            <p>You will be asked for MySql password. Enter password and if all went well, refresh the page by clicking <a href=""><strong>here</strong></a>.</p>
                            <?php
                        else:
                            ?>
                            <p class="alert alert-success"><i class="glyphicon glyphicon-ok"></i> Installation completed, queries executed successfully.</p>
                            <?php include DOC_ROOT.'includes/html/db-tuning-help.html';?>
                            <?php include DOC_ROOT.'includes/html/delete-files-help.html';?>
                            <p>MASSCAN Web UI is ready for use. Refresh this page by pressing F5 or clicking <a href="/">here</a> to start.</p>
                            <?php
                        endif;
                    endif;
                else:
                    if (!is_file(DOC_ROOT.'db-structure.sql')):
                        ?>
                        <p class="alert alert-danger"><i class="glyphicon glyphicon-remove"></i> Installer can not find file db-structure.sql in <?php echo DOC_ROOT;?> and can not create necessary db tables.</p>
                        <p>Check our <a href="https://github.com/offensive-security/masscan-web-ui" target="_blank">Github</a> page for latest source and help.</p>
                        <?php
                    elseif (!is_readable(DOC_ROOT.'db-structure.sql')):
                        ?>
                        <p class="alert alert-danger"><i class="glyphicon glyphicon-remove"></i> File db-structure.sql in <?php echo DOC_ROOT;?> is not readable and installer can not execute required queries.</p>
                        <p>Make it readable and refresh page by clicking <a href="/">here</a> to try again.</p>
                        <?php
                    else:

                    endif;
                endif; ?>
            </div> <!-- end of .jumbotron -->
        </div> <!-- end .col-md-12 -->
    </div> <!-- end of .row -->
</div> <!-- end of .container -->
<?php include DOC_ROOT.'includes/footer.php';
