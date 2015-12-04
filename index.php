<?php
define('APP_NAME', 'massscan');
require dirname(__FILE__).'/includes/config.php';
require dirname(__FILE__).'/includes/functions.php';
require dirname(__FILE__).'/includes/data_validation.php';
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
   <meta charset="utf-8" />
   <title>MasScan | Home</title>
   <!-- BEGIN GLOBAL MANDATORY STYLES -->
   <link href="/assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />
   <link href="/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" />
   <link href="/assets/css/style.css" rel="stylesheet" />
   <link href="/assets/css/red.css" rel="stylesheet" id="style_color" />
   <link href="/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
   <link href="/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet" />
   <link href="/assets/css/digip.css" rel="stylesheet" />
   <!-- END GLOBAL MANDATORY STYLES -->
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
   <!-- BEGIN HEADER -->
   <div id="header" class="navbar navbar-inverse navbar-fixed-top">
      <!-- BEGIN TOP NAVIGATION BAR -->
      <div class="navbar-inner">
         <div class="container-fluid d1280">
            <!-- BEGIN LOGO -->
            <a href="/index.php"><img src="/assets/img/offsec.png"/></a>
            <!-- END LOGO -->
            <ul  class="nav navbar-nav pull-right">
               <li>
                  <a href="/index.php"><i class="icon-home"></i><span class="title"> Home</span></a>
               </li>
            </ul>
         </div>
      </div>
      <!-- END TOP NAVIGATION BAR -->
   </div>
   <!-- END HEADER -->


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

   <!-- BEGIN FOOTER -->
   <div id="footer">
      <div class="container-fluid d1280">
         <h5>MasScan Web UI v0.1</h5>
      </div>
   </div>
   <!-- END FOOTER -->
   <!-- BEGIN CORE PLUGINS -->
   <script src="/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
   <!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
   <script src="/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
   <script src="/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
   <script src="/assets/plugins/breakpoints/breakpoints.js" type="text/javascript"></script>
   <!-- IMPORTANT! jquery.slimscroll.min.js depends on jquery-ui-1.10.1.custom.min.js -->
   <script src="/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
   <script src="/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
   <!-- END CORE PLUGINS -->
   <!-- BEGIN PAGE LEVEL SCRIPTS -->
   <script src="/assets/scripts/app.js"></script>
   <script src="/assets/scripts/scripts.js"></script>
</body>
<!-- END BODY -->
</html>