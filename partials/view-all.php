<div class="viewer wrap">
<?php
	/**
	* check if there is an action to reset counters
	*/
	if ( isset ( $_POST['reset_page'] ) ):
		if ( $page == ""){
            $page = stripslashes( $_POST['reset_page'] );
        }
		if ( WHTP_Hits::reset_page_count() ) :
			if ( $page != "" ): ?>
                <div class="updated">
                    <p>
                        <?php echo sprintf( __('The count for the page "%s" has been reset successfully.', 'whtp'), esc_attr( $page ) ); ?>
                    </p>
                </div>'; 
            <?php else: ?>
				<div class="updated">
                    <p><?php _e( 'The count for all pages has been reset successfully.', 'whtp' ); ?></p>
                </div>
            <?php endif;		
		else: ?>
			<div class="update-nag">
                <p><?php _e( 'Failed to reset page counts', 'whtp' ); ?></p>
            </div><?php
        endif;
    endif;
    
	if ( isset( $_POST['delete_page'] ) ) {
		if ( WHTP_Hits::delete_page() ){ ?>
			<div class="updated fade" id="message">
				<p>Page count(s) deleted. New entries will be made when users visit your pages again. If you no longer wish to count visits on certain pages, go to the page editor and remove the <code>[whohit]..[/whohit]<code> shortcode.
				</p>
			</div><?php
		}else{ ?>
			<div class="update-nag fade">
				<p><?php _e( 'Failed to remove page count(s).', 'whtp' ); ?></p>
			</div>
		<?php }
    }
    

	if ( isset( $_POST['discount_page'] ) ) :
        if ( WHTP_Hits::discount_page() ) : ?>
            <div class="updated fade" id="message">
                <p>The Page "' . $page . '" has been discounted by ' . $discountby .'</p>
                <?php echo sprintf( 
                    __('The Page "%s" has been discounted by %d', 'whtp'), 
                    esc_attr( $page ), 
                    esc_attr( $discountby)
                ); ?>
            </div><?php
        else: ?>
                <div class="update-nag">
                    <p><?php _e( 'Failed to discount on the page', 'whtp' ); ?></p>
                </div><?php
        endif;
    endif;

	/**
	* Check if there is an action to be performed
	* to reset ip info
	*/
	if ( isset( $_POST['reset_ip'] ) ) :
		if ( WHTP_Hit_Info::reset_ip_info() ) : ?>
			<div class="updated">
				<p>
                    <?php echo sprintf( __( 'The count for ip address: "%s" has been reset successfully.', 'whtp' ), esc_attr( $_POST['reset_ip'] ) ); ?></p>
            </div><?php 
        else: ?>
			<div class="update-nag">
				<p><?php echo sprintf( __( 'Failed to reset count for IP: %s', 'whtp' ), esc_attr( $_POST['reset_ip'] ) ); ?></p>
            </div><?php
        endif; 
	endif;

if ( isset( $_POST['delete_ip'] ) ) :
	$ip_address = esc_attr($_POST['delete_this_ip']);	
	$delete_ip  = esc_attr ( $_POST['delete_ip'] );
	?>
	<div class="viewer wrap">
		<?php if ( WHTP_Hit_Info::delete_ip( $ip_address, $delete_ip ) ): ?>
			<div class="updated">
				<p><?php _e("IP addresse(s) removed from the database.", "whtp"); ?></p>
			</div>
		<?php else: ?>
			<div class="update">
				<p><?php _e("Failed to remove IP addresse(s) from database", "whtp"); ?></p>
			</div>
		<?php endif; ?>
	</div>
<?php endif;
	
if ( isset ( $_POST['deny_ip'] ) ): 
    if ( WHTP_Hit_Info::deny_ip() ) : ?>
        <div class="updated fade"  id="message">
            <p><?php _e( 'The IP Address will be ignored and will not be counted.', 'whtp' ); ?></p>
        </div>
    <?php else: ?>
        <div class="updated">
            <p><?php _e( 'Failed to add IP to ignore list', 'whtp'); ?></p>
        </div>
    <?php endif;
endif;


if (isset ($_POST['view_visitor'] ) ): ?>
	<h1><?php sprintf( __( "Visitor Data Goes Here for %s"), esc_attr( $view_visitor) ); ?></h1>";
<?php
endif;
?>
</div>
<div class="wrap">	
	<h2><?php _e( 'Who Hit The Page Hit Counter', 'whtp' ); ?></h2>
    <p>
        <?php _e( 'Here you will see the raw hit counter information. This page lists all your pages and their respective counts and also the visiting IP addresses with their respective counts and other information.', 'whtp' ); ?>
    </p>
    <div id="poststuff" class="metabox-holder has-right-sidebar">
        <div id="side-info-column" class="inner-sidebar">
            <div id="side-sortables" class="meta-box-sortables ui-sortable">
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle"><?php _e( 'Support', 'whtp' ); ?></h3>
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
                    <h3 class="hndle"><?php _e( 'Subscribe to updates', 'whtp' ); ?></h3>
                    <div class="inside welcome-panel-column welcome-panel-last">
					   <?php
                            if(isset($_POST['whtpsubscr']) && $_POST['whtpsubscr'] == "y"){
                                WHTP_Functions::whtp_admin_message_sender();
                            }
                            WHTP_Functions::signup_form();
                        ?>
                        <p>Thank you once again!</p>
                    </div>
                </div>
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle"><?php _e( 'Need More', 'whtp' ); ?></h3>
                    <div class="inside welcome-panel-column welcome-panel-last">
                        <h4>Display a hit counter widget on any page or post. Its easy to change the colors and the font sizes for the numbers.</h4>
                        <a href="http://shop.whohit.co.za/" target="_blank">
                        	<img src="<?php echo WHTP_IMAGES_URL . 'widget_get.png'; ?>" alt="Get front end widget for who hit the page" />
                        </a>
                        <a href="http://shop.whohit.co.za/" class="button button-primary button-hero" style="width:100%; text-align:center;" target="_blank">Download Now</a>
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
                    	<h3 class="hndle">
                            <?php _e( 'Pages visited and number of visits per page.', 'whtp' ); ?>
                        </h3>
                        <div class="inside">
							<?php require_once( WHTP_PLUGIN_DIR_PATH . 'partials/view/all-page-hits.php'); ?>
    					</div>
                    </div>
					<div class="postbox inside">
                    	<h3 class="handle">
                            <?php _e( 'Visitors\' IP addresses and Information', 'whtp' ); ?>    
                        </h3>
                        <div class="inside">
							<?php require_once( WHTP_PLUGIN_DIR_PATH . 'partials/view/visiting-ip-addresses.php'); ?>
						</div>
					</div>
			</div>
        </div>
    </div>
</div><!-- Wrap -->