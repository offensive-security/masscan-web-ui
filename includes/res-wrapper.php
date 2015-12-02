<div class="row-fluid">
    <div class="span12">
        <div class="widget box light-grey">
            <div class="widget-title">
                <h4><i class="icon-globe"></i>Results</h4>
                <span class="ajax-throbber-wrapper"><img src="/assets/img/ajax-loader.gif" alt="Loading..." title="Loading..." id="ajax-loader" /></span>
                <div class="btn-group pull-right" style="margin-top:3px; margin-right:3px">
                    <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">Save <i class="icon-angle-down"></i></button>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0);" onclick="return exportResultsToXML('<?php echo http_build_query($filter);?>');" style="margin-left:10px;" id="export-link">Export to XML</a></li>
                    </ul>
                </div>
            </div>
            <div id="ajax-list-container">
                <?php require dirname(__FILE__).'/list.php';?>
            </div>
        </div>
        <!-- END EXAMPLE TABLE widget-->
        <div id="myModal" style="width:90%; margin:0 5%; left:0;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-header">
                <h3 id="myModalLabel"></h3>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            </div>
        </div>
        <!-- END MODAL DIALOG PORTLET-->

    </div>
</div> <!--end of .row-fluid -->