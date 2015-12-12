<?php
define('DOC_ROOT', dirname(__FILE__).'/');
require dirname(__FILE__).'/config.php';
require dirname(__FILE__).'/includes/functions.php';
require dirname(__FILE__).'/includes/data_validation.php';
include dirname(__FILE__).'/includes/header.php';
?>
<!-- BEGIN PAGE CONTENT -->
<div class="container-fluid">
    <div class="row">
        <!-- BEGIN FORM CONTENT-->
         <div class="panel panel-default margin">
             <div style="display:block;" class="panel-heading clearfix" data-toggle="collapse" href="#collapse">
                 <h4 class="pull-left"><i class="glyphicon glyphicon-search"></i> Search</h4>
                 <div id="search-params" class="pull-left"></div>
                 <a data-toggle="collapse" href="#collapse" style="display:block;" class="pull-right glyphicon glyphicon-minus"></a>
             </div>
             <div id="collapse" class="panel-collapse collapse in">
                 <div class="panel-body">
                     <form action="/index.php" class="horizontal-form" onsubmit="return submitSearchForm();" id="form">
                         <input type="hidden" name="action" value="search"/>
                         <div class="row">
                             <div class="col-md-2">
                                 <div class="form-group">
                                     <label for="ipAddress">IP Address</label>
                                     <input type="text" class="form-control input-sm" id="ipAddress" name="ip" value="<?php echo htmlentities($filter['ip']); ?>" placeholder="xxx.xxx.xxx.xxx">
                                 </div>
                             </div>
                             <div class="col-md-2">
                                 <div class="form-group">
                                     <label for="portN">Port Number</label>
                                     <input type="text" class="form-control input-sm" id="portN" name="port" value="<?php if ($filter['port'] > 0):echo (int)$filter['port'];endif; ?>" placeholder="1-65535">
                                 </div>
                             </div>
                             <div class="col-md-2">
                                 <div class="form-group">
                                     <label for="serviceState">State</label>
                                     <input type="text" class="form-control input-sm" id="serviceState" name="state" value="<?php echo htmlentities($filter['state']); ?>" placeholder="open/closed">

                                 </div>
                             </div>
                             <div class="col-md-3">
                                 <div class="form-group">
                                     <label for="pProtocol">Protocol</label>
                                     <input type="text" class="form-control input-sm" id="pProtocol" name="protocol" value="<?php echo htmlentities($filter['protocol']); ?>" placeholder="tcp/udp">
                                 </div>
                             </div>
                             <div class="col-md-3">
                                 <div class="form-group">
                                     <label for="pService">Service</label>
                                     <input type="text" class="form-control input-sm" id="pService" name="service" value="<?php echo htmlentities($filter['service']); ?>" placeholder="ftp/msrpc/smtp">
                                 </div>
                             </div>
                         </div> <!-- end of .row-->
                         <div class="row">
                             <div class="col-md-7">
                                 <div class="form-group">
                                     <label for="pBanner">Service Banner/Title</label>
                                     <input type="text" class="form-control input-sm" id="pBanner" name="banner" value="<?php echo htmlentities($filter['banner']); ?>" placeholder="IIS/Apache/ESMTP">
                                 </div>
                             </div>
                             <div class="col-md-2">
                                 <br>
                                 <div class="checkbox">
                                     <label><input type="checkbox" name="exact-match" value="1"<?php if ($filter['exact-match'] === 1): echo ' checked'; endif; ?>>Exact match</label>
                                 </div>
                             </div>
                             <div class="col-md-3">
                                 <br>
                                 <button type="submit" class="btn btn-primary btn-sm" style="width:100px;"><i class="glyphicon glyphicon-ok"></i> Go</button>
                                 <span class="ajax-throbber-wrapper-form"><img src="/assets/img/ajax-loader.gif" alt="Loading..." title="Loading..." id="ajax-loader-form"/></span>
                             </div>
                         </div> <!-- end of .row-->
                     </form>
                 </div>
             </div>
         </div>
         <!-- END FORM CONTENT-->
     </div> <!--end of .row -->

    <div class="row" id="ajax-search-container">
        <?php require dirname(__FILE__).'/includes/res-wrapper.php'; ?>
        <?php if (empty($results['data'])): ?>
            <p class="text-right import-help">How to import data? Click <a href="javascript:void(0);" onclick="showImportHelp();">here</a> for more info.</p>
        <?php endif;?>
    </div>
</div> <!-- end of .container-fluid -->
<!-- END PAGE CONTENT -->
<?php
include dirname(__FILE__).'/includes/footer.php';