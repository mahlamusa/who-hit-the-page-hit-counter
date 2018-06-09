<?php
	global $wpdb;
	
	$user_stats = array();
	$browsers = array();
	$top_countries = array();
	
    $hit_result = WHTP_Hits::get_hits();
    $total_hits = count( $hit_results );
	
	$browsers = WHTP_Browser::get_browsers();
	
	//total unique visitors
	$total_unique = WHTP_Hit_Info::count_unique();
	
	$top_visitors = WHTP_Hit_Info::top( 5 );
	
	$top_countries = WHTP_Visiting_Countries::get_-top_countries( 15 );

?>
<div class="wrap">	
	<h2>Who Hit The Page Hit Counter</h2>
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
                    <h3 class="hndle">Need More</h3>
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
                    </div>
                </div>
            </div>
        </div>
        <div id="post-body">
            <div id="post-body-content">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                    <div class="postbox inside">
                    	<div class="handlediv" title="Click to toggle"><br /></div>
                    	<h3 class="hndle">Summary</h3>
                        <div class="inside">
                            <div id="welcome-panel" class="welcome-panel">                                
                                <div class="welcome-panel-content">
                                    <p class="about-description">This is a summary of your page hit statistics.</p>
                                    <!-- Totals -->
                                    <br />
                                    <p class="about-description"><strong>Total Page Hits: <?php echo $total_hits; ?></strong></p>
                                    <p class="about-description"><strong>Total Unique Visitors : <?php echo $total_unique; ?></strong></p>
                                    <hr align="center" />
                                    <!-- /totals -->
                                    <div class="welcome-panel-column-container">
                                        <div class="welcome-panel-column">
                                            <h4>Top 5 Visitors</h4>                                                
                                            <?php 
                                            if ( is_admin() ){                                                    
                                                $limit = count ( $top_visitors );                                                    
                                                if ($limit > 5) {
                                                    $limit = 5;
                                                }
                                                if ($limit > 0){
                                                    echo '<table cellpadding="5" cellspacing="2">' . "\n";
                                                    echo "\t<tbody>\n";
                                                    for ($count = 0; $count < $limit; $count ++){
                                                        $top = $top_visitors[$count] ;	
                                                        echo '<tr><td><a href="admin.php?page=whtp-visitor-stats&ip=' 
                                                        . $top->ip_address 
                                                        . '">' . $top->ip_address 
                                                        . '</a></td><td>' . $top->ip_total_visits
                                                        . '</td></tr>' . "\n";
                                                    }
                                                    echo "\t</tbody>\n";
                                                    echo "</table>";
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="welcome-panel-column">
                                            <h4>Top Visiting Countries</h4> 
                                            <?php
                                            
                                            if ( count ( $top_countries ) ) :
                                            ?>
                                            <ul>
                                                <?php
                                                
                                                for ( $count = 0; $count < count ( $top_countries ); $count ++ ) :
                                                    $top_country = $top_countries[$count];
													$image_prefix =  $top_country['country_name'] ;
													if ( $image_prefix == 'Unknown Country')
														$image_prefix = '0';
													else
                                                        $image_prefix = strtolower( $top_country['country_code'] );
                                                    ?>
                                                    <li>
                                                        <img 
                                                        src="<?php echo WHTP_FLAGS_URL . $image_prefix; ?>.png" 
                                                        alt="Flag of '<?php echo $top_country['country_code']; ?>" 
                                                        title="<?php echo $top_country['country_name']; ?>" />
                                                        <?php echo  $top_country['country_name'] . "\t ,"
                                                    . $top_country['country_code'] . "\t ("
                                                    . $top_country['count']; ?>) 
                                                    </li>';
                                                <?php endfor; ?>
                                            </ul>
                                            
                                            <?php endif;?>
                                        </div>
                                        <div class="welcome-panel-column welcome-panel-last">
                                            <h4><?php _e( 'Used Browsers', 'whtp' ); ?></h4>                    
                                            <?php if ( count ( $browsers ) > 0 ): ?>
                                                <ul>
                                                <?php foreach ( $browsers as $browser ) : ?>
                                                    <li>
                                                        <div class="welcome-icon welcome-widgets-menus">
                                                            <?php echo esc_attr( $browser->agent_name ); ?>
                                                        </div>
                                                    </li>                      
                                                <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p><?php _e( "No Browsers used so far", "whtp"); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="postbox inside">
                    	<div class="handlediv" title="Click to toggle"><br /></div>
                    	<h3 class="hndle">Disclaimer</h3>
                        <div class="inside">
                            <?php require_once( WHTP_PLUGIN_DIR_PATH . 'partials/disclaimer.php' ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Wrap -->
