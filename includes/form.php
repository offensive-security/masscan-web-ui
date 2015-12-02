<!-- BEGIN FORM CONTENT-->
<div class="tab-content">
    <div class="tab-pane active" id="tab_1">
        <div class="widget">
            <div class="widget-title">
                <h4><i class="icon-reorder"></i>Search</h4>
            </div>
            <div class="widget-body form">
                <!-- BEGIN FORM-->
                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $er): ?>
                            <li><?php echo $er; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <form action="/index.php" class="horizontal-form" onsubmit="return submitSearchForm();" id="form">
                    <input type="hidden" name="action" value="search"/>

                    <div class="row-fluid">
                        <div class="span2 ">
                            <div class="control-group">
                                <label class="control-label" for="ipAddress">IP Address</label>

                                <div class="controls">
                                    <input type="text" id="ipAddress" name="ip" class="span12"
                                           value="<?php echo htmlentities($filter['ip']); ?>"
                                           placeholder="xxx.xxx.xxx.xxx">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="span2">
                            <div class="control-group">
                                <label class="control-label" for="portN">Port Number</label>

                                <div class="controls">
                                    <input type="text" id="portN" name="port" class="span12"
                                           value="<?php if ($filter['port'] > 0):echo (int)$filter['port'];endif; ?>"
                                           placeholder="1-65535">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="span2">
                            <div class="control-group">
                                <label class="control-label" for="serviceState">State</label>

                                <div class="controls">
                                    <input type="text" id="serviceState" name="state"
                                           value="<?php echo htmlentities($filter['state']); ?>" class="span12"
                                           placeholder="open/closed">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="span3 ">
                            <div class="control-group">
                                <label class="control-label" for="pProtocol">Protocol</label>

                                <div class="controls">
                                    <input type="text" id="pProtocol" name="protocol" class="span12"
                                           value="<?php echo htmlentities($filter['protocol']); ?>"
                                           placeholder="tcp/udp">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="span3 ">
                            <div class="control-group">
                                <label class="control-label" for="pService">Service</label>

                                <div class="controls">
                                    <input type="text" id="pService" name="service" class="span12"
                                           value="<?php echo htmlentities($filter['service']); ?>"
                                           placeholder="ftp/msrpc/smtp">
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                    <div class="row-fluid">
                        <div class="span8">
                            <div class="control-group">
                                <label class="control-label" for="pBanner">Service Banner/Title</label>

                                <div class="controls">
                                    <input type="text" id="pBanner" name="banner" class="span12"
                                           value="<?php echo htmlentities($filter['banner']); ?>"
                                           placeholder="IIS/Apache/ESMTP"/>
                                </div>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="span2">
                            <div class="checkbox" style="margin-top:28px; margin-left:20px;">
                                <label> <input type="checkbox" name="exact-match"
                                               value="1"<?php if ($filter['exact-match'] === 1): echo ' checked'; endif; ?>>
                                    Exact match</label>
                            </div>
                        </div>
                        <div class="span2">
                            <br/>
                            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Go</button>
                            <span class="ajax-throbber-wrapper-form"><img src="/assets/img/ajax-loader.gif"
                                                                          alt="Loading..." title="Loading..."
                                                                          id="ajax-loader-form"/></span>
                        </div>
                        <!--/span-->
                    </div>
                    <!--/row-->
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
</div>
<!-- END FORM CONTENT-->