<div class="wrap">	
	<h2>Who Hit The Page Hit Counter</h2>
    <p></p>
    <div id="poststuff" class="metabox-holder has-right-sidebar">
        <div id="side-info-column" class="inner-sidebar">
            <div id="side-sortables" class="meta-box-sortables ui-sortable">
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Support</h3>
                    <div class="inside welcome-panel-column welcome-panel-last">
                        <h4>Donate $10 via 2Checkout</h4>
                        <p>Any Amount is highly Appreciated</p>
                        <form action='https://www.2checkout.com/checkout/purchase' method='post'>
                          <input type='hidden' name='sid' value='102959491'>
                          <input type='hidden' name='quantity' value='1'>
                          <input type='hidden' name='product_id' value='9'>
                          <label>Quantity</label>
                          <input name='quantity' type='text' size='5' value="1">
                          <input name='submit' type='submit' class="button button-primary" value='Donate through 2CO'>
                        </form>
                        <span>2Checkout.com Inc. (Ohio, USA) is a payment facilitator for goods and services provided by Three Pixels Web Solutions.</span>
                    </div>  
                </div>
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Subscribe to updates</h3>
                    <div class="inside welcome-panel-column welcome-panel-last">
					   <?php
                            if(isset($_POST['whtpsubscr']) && $_POST['whtpsubscr'] == "y"){
                                WHTP_Functions::whtp_admin_message_sender();
                            }
                            WHTP_Functions::whtp_signup_form();
                        ?>
                        <p>Thank you once again!</p>
                    </div>
                </div>
                
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Please Rate this plugin</h3>
                    <div class="inside welcome-panel-column welcome-panel-last">
                        <p><b>Dear User</b></p>
                        <p>Please 
                        <a href="http://wordpress.org/support/view/plugin-reviews/who-hit-the-page-hit-counter">Rate this plugin now.</a> if you appreciate it.
                        Rating this plugin will help other people like you to find this plugin because on wordpress plugins are sorted by rating, so rate it high and give it a fair review to help others find it.<br />
                        </p>
                        <div class="welcome-panel-column">
                            <h3>Credits Where They Belong</h3>
                            <div>
                                This product includes GeoLite2 data created by MaxMind, available from
                                <a href="http://www.maxmind.com">http://www.maxmind.com</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="post-body">
            <div id="post-body-content">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                	<div class="postbox inside">
						<div class="handlediv" title="Click to toggle"><br /></div>
                    	<h3 class="hndle">Settings</h3>
    					<div class="inside">
                        	<!-- --> 
                            <div id="welcome-panel" class="welcome-panel">
                                <div class="welcome-panel-content">
                                    <div class="welcome-panel-column-container">
                                        <div class="welcome-panel-column">
                                            <h2>Uninstall Settings!</h2>
                                            <?php
                                                if ( isset ( $_POST['update-uninstall-option'] ) ){
                                                    $update_uninstall = stripslashes( $_POST['uninstall-action'] );
                                                    if ( update_option ( "whtp_data_action",  $update_uninstall) ){
                                                        echo '<div id="message" class="updated">
                                                                <p>Settings updated.</p> 
                                                            </div>';
                                                    }							
                                                }
                                                $option = get_option('whtp_data_action');
                                            ?>
                                            <p class="about-description">What should happen when you un-install the plugin?</p>
                                            <form action="" name="" method="post">
                                                <p>
                                                    <label for="uninstall-action">Select One Option</label>
                                                </p>
                                                <p>
                                                    <input type="radio" name="uninstall-action" value="delete-all" 
                                                    <?php if ($option == "delete-all") echo "checked"; ?>  />
                                                    <strong>Delete all Tables</strong> and <strong>Data</strong>
                                                </p>
                                                <p>
                                                    <input type="radio" name="uninstall-action" value="clear-tables"
                                                    <?php if ($option == "clear-tables") echo "checked"; ?>  />
                                                    <strong>Clear data</strong>, leave table structures.
                                                </p>
                                                <p>
                                                    <input type="radio" name="uninstall-action" value="do-nothing"
                                                    <?php if ($option == "do-nothing") echo "checked"; ?>  />
                                                    <strong>Leave all</strong> tables and data
                                                </p>
                                                <p>
                                                    <input type="hidden" name="update-uninstall-option" value="update-uninstall-option" /> 
                                                    <input type="submit" value="Update Options" class="button button-primary" />
                                                </p>
                                            </form>
                                       	</div>
                                       	<!-- -->
                                      	<div class="welcome-panel-column">
                                           <h2>Backup Settings</h2>
                                           <?php
                                                if ( isset ( $_POST['update-backup-options'] ) ){
                                                    $update_backup = stripslashes( $_POST['backup-action'] );
                                                    if ( update_option ( "whtp_data_export_action",  $update_backup) ){
                                                        echo '<div id="message" class="updated">
                                                                <p>Settings updated.</p> 
                                                            </div>';
                                                    }							
                                                }
                                                $export_option = get_option("whtp_data_export_action");
                                            ?>
                                            <p class="about-description">What should happen when you restore a backup?</p>
                                            <form action="" name="" method="post">
                                                <p>
                                                    <label for="uninstall-action">Select One Option</label>
                                                </p>
                                                <p>
                                                    <input type="radio" name="backup-action" value="delete-all"
                                                    <?php if ($export_option == "delete-all") echo "checked"; ?>  />
                                                    <strong>Override</strong> existing data 
                                                </p>
                                                <p>
                                                    <input type="radio" name="backup-action" value="clear-tables"
                                                    <?php if ($export_option == "clear-tables") echo "checked"; ?>  />
                                                    <strong>Update</strong> existing data, <strong>accumulate</strong> counts
                                                </p>
                                                <p>
                                                    <input type="radio" name="backup-action" value="do-nothing"
                                                    <?php if ($export_option == "do-nothing") echo "checked"; ?>  />
                                                    <strong>Skip/Ignore</strong> Existing Records
                                                </p>
                                                <p>
                                                    <input type="hidden" name="update-backup-options" value="update-backup-options" /> 
                                                    <input type="submit" value="Update Options" class="button button-primary" />
                                                </p>
                                            </form>
                                       </div>
                                   	</div>
                               	</div>
                           	</div>
                      	</div>
                	</div>
               	</div>
            </div>
       </div>
</div>