<?php
define('APP_NAME', 'massscan');
require dirname(__FILE__).'/config.php';
require dirname(__FILE__).'/includes/functions.php';
require dirname(__FILE__).'/includes/data_validation.php';
if (isset($_GET['form'])):
    require dirname(__FILE__).'/includes/res-wrapper.php';
else:
    require dirname(__FILE__).'/includes/list.php';
endif;
