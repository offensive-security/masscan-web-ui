<?php
define('APP_NAME', 'massscan');
require dirname(__FILE__).'/includes/config.php';
require dirname(__FILE__).'/includes/functions.php';
require dirname(__FILE__).'/includes/data_validation.php';
//End of input validation
$page_title = "MasScan | Home";
require dirname(__FILE__).'/includes/header.php';
?>
<!-- BEGIN CONTAINER -->
   <div id="container" class="row-fluid">
      <!-- BEGIN PAGE -->  
      <div id="body">
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid d1280">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
               <div class="span12">  
                  <h1 class="page-title">
                     MasScan Home
                  </h1>
               </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
			<?php require dirname(__FILE__).'/includes/form.php';?>
            <div id="content">
               <?php require dirname(__FILE__).'/includes/res-wrapper.php'; ?>
			</div> <!-- end of #content -->
            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
   </div>
<!-- END CONTAINER -->
<?php require dirname(__FILE__).'/includes/footer.php';?>