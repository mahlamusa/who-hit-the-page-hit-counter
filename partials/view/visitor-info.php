<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
	global $wpdb;
	$num_ips = WHTP_Hit_Info::count();
	/*
	/*
	* if there are some ips already listed, then proceed with the statistics
	* else display a button to the help menu
	*/
	$visitor_ip = '';
	if ( $num_ips > 0 ) {
		if ( isset ( $_GET['ip'] ) && $_GET['ip'] != "" ){
			$visitor_ip = stripslashes( $_GET['ip'] );//"192.10.10.253";//;france = "80.248.208.145", za = 41.61.255.255;, za = 41.77.63.255;
			$ip_id = WHTP_Hit_Info::get_ip_id ($visitor_ip );
			//echo display_select_visitor_ip();
			//wp_reset_postdata();
		}
		if( isset ( $_POST['ip'] ) ){
			$visitor_ip = esc_attr( $_POST['ip'] );
			$ip_id = WHTP_Hit_Info::get_ip_id($visitor_ip);
		}
		
		if ( $visitor_ip == ''){
			$ip_id = 0;
			$visitor_ip = '127.0.0.1';
		}
		//show the select ip address form
		//echo display_select_visitor_ip();
		
		/*
		*	 Results are stored in arrays
		*/
			
		$user_stats = array();
		$info_result = array();
		$user_agents = array();
		$page_ids = array();
		$hit_result = array();
		$pages_visited = array();
		$countries = array();
		$agent_ids = array();
		$browsers = array();
		/*
		* Given the page ids, get the page names
		* save to array of pages and counts
		*/
		$page_ids = WHTP_Ip_Hits::page_ids_from_ip_id($ip_id);
		
		for ( $count = 0; $count < count($page_ids); $count ++ ){
			$page_id = $page_ids[$count];		
			$page = WHTP_Hits::get_page_by_id( $page_id );
			$pages_visited[] = $page; // $row = ({"page","count"})
		}
		/*
		* Get hitinfo
		*
		*/
		$info_result = WHTP_Hit_Info::hits_for_ip( $visitor_ip );
		/*
		* Select the country associated with the selected $ip_id
		* and store the countries as an array, then display the first country
		*/
		$select_country = "SELECT country_name FROM whtp_ip2location WHERE INET_ATON('" . $visitor_ip . "') 
						BETWEEN decimal_ip_from AND decimal_ip_to";                    
		$country = $wpdb->get_col($select_country);
		
		
		/*
		* Select the browsers used by the selected $ip_id
		*
		*/
		$agent_ids = WHTP_Ip_Hits::agent_ids_from_ip_id( $ip_id );
		
		/*
		*	Get browsers used
		*	returns an array of browsers
		*	pass an array of browser ids,you will get browsers with those ids
		*   pass an empty string, you get an array of all browsers ever used
		*/
		for ( $count = 0; $count < count($agent_ids); $count ++ ){
			$agent_id = $agent_ids[$count];
			$browser = $wpdb->get_var ( "SELECT agent_name FROM whtp_user_agents WHERE agent_id='$agent_id' LIMIT 0,1" );
			if ( $browser ){
				$browsers[] = $browser;
			}
		}
		
		
	?>
<div class="wrap">	
	<h2>Who Hit The Page Hit Counter</h2>
    <p>To start viewing the details of a single visitor, select the visitor's IP below and click "View Details", do the same to view another IP.</p>
    <?php
		echo display_select_visitor_ip();
	?>
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
                            WHTP_Functions::signup_form();
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
                    	<h3 class="hndle">View Visitor's Behaviour (IP: <?php echo $visitor_ip; ?>)</h3>
                        <div class="inside">
                           <div id="welcome-panel" class="welcome-panel">
                           		<h3>Visitor Statistics!</h3>
                                <div class="welcome-panel-content">
                                    <p class="about-description">
                                        This are the statistics for a single user/visitor with IP Address :<?php echo $visitor_ip; ?>
                                    </p>
                                    <!-- Top -->
                                    <div class="welcome-panel-column-container">
                                        <div class="welcome-panel-column">
                                            <h4>Visitor's IP: <?php if (!$visitor_ip) echo "IP Address Not Set"; else echo $visitor_ip; ?></h4>
                                        </div>
                                        <div class="welcome-panel-column">
                                            <h4>Total Visits: <?php if (!$info_result) echo "Not Set"; 
                                            else echo $info_result->ip_total_visits; ?></h4>
                                        </div>
                                        <div class="welcome-panel-column welcome-panel-last">
                                            <h4>Location: <?php if ( !$country ) echo "Unknown"; else echo $country[0]; ?></h4>
                                        </div>
                                    </div>
                                </div>
                           </div>
                           <div id="welcome-panel" class="welcome-panel">
                           		<h3>Date and Time of First and Last Visit</h3>
                                <div class="welcome-panel-content">                                	    
                                    <div class="welcome-panel-column-container">
                                        <div class="welcome-panel-column">
                                           <?php if ( $info_result ){ ?>
                                            
                                            <ul>
                                                <li>
                                                    First Visit : 
                                                        <span class="entry-date">
                                                            <?php echo $info_result->datetime_first_visit; ?>
                                                        </span>
                                                </li>
                                                <li>
                                                    Last Visit : 
                                                    <span class="entry-date">
                                                        <?php echo $info_result->datetime_last_visit; ?>
                                                    </span>
                                                </li>
                                            </ul>
                                             <?php } //end if ?>
                                         </div>
                                    </div>
                                </div>
                           </div>
                     	</div>
                    </div>
                    <div class="postbox inside">
                        <div class="handlediv" title="Click to toggle"><br /></div>
                        <h3 class="hndle">View Visitor's Behaviour (IP: <?php echo $visitor_ip; ?>)</h3>
                        <div class="inside">
                            <div id="welcome-panel" class="welcome-panel">
                                <div class="welcome-panel-content">     
                                    <!-- Main -->
                                    <div class="welcome-panel-column-container">
                                        <!--<div class="welcome-panel-column">
                                            <h4></h4>
                                            <a class="button button-primary button-hero load-customize hide-if-no-customize" href="#">
                                            Customize Your Site</a>
                                            <a class="button button-primary button-hero hide-if-customize" href="#">
                                            Customize Your Site</a>
                                            <p class="hide-if-no-customize">or, <a href="#">change your theme completely</a></p>
                                        </div>-->
                                        <div class="welcome-panel-column">
                                            <h4>Pages Visited by this user</h4> 
                                            <ul>
                                            <?php
                                                if ( !$page_ids || count($page_ids) == 0 ){
                                                    echo '<a href="#" class="welcome-icon welcome-view-site">Un-identified Page</a>';
                                                }
                                                else{
                                                    foreach ( $pages_visited as $page){
                                                        echo '<a href="#" class="welcome-icon welcome-view-site">'  . $page->page . '('.$page->count . ')</a>';	
                                                    }
                                                }
                                            ?>
                                            </ul>
                                        </div>
                                        <div class="welcome-panel-column welcome-panel-last">
                                            <h4>The User Has The following Browsers</h4>
                                            <ul>
                                            <?php
                                                if ( !$browsers || 0 == count( $browsers )){
                                                    echo '<li><div class="welcome-icon welcome-widgets-menus">Unknown Browser(s)</div></li>';
                                                }else{
                                                    for ( $count=0; $count < count($browsers); $count ++){
                                                        echo '<li><div class="welcome-icon welcome-widgets-menus">';
                                                        echo $browsers[$count];
                                                        echo '</div></li>';       
                                                    }
                                                }
                                            ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- welcome-panel-content -->
                            </div><!-- welcome-panel -->
                        </div>
                     </div>
                     <div class="postbox inside">
                    	<div class="handlediv" title="Click to toggle"><br /></div>
                    	<h3 class="hndle">Disclaimer</h3>
                        <div class="inside">
                        	<p>This product includes GeoLite2 data created by MaxMind, available from <a href="http://www.maxmind.com">http://www.maxmind.com</a></p>
                            <p>I, Lindeni Mahlalela, referred to as "mahlamusa" don't guarantee the accuracy of the Geolocation data used in this plugin. I do not claim that I have gathered this data myself, but this product uses GeoLite2 data created by MaxMind, available from <a href="http://www.maxmind.com">http://www.maxmind.com</a>. If the data is inaccurate, please be advisable tha providing accurate data is beyond my personal capacity. When this version of the plugin was released, the data was 80% accurate.</p>
                             <p></p>
                        </div>
                    </div>
			<?php
                }
                /*
                * else there are no ips to show stats for
                * display a message for the user to visit how to get started/help page
                */
                else{ 
                
                    if ( is_admin() ) {
            ?>
                 	<div class="postbox inside">
                        <div class="handlediv" title="Click to toggle"><br /></div>
                        <h3 class="hndle">Sorry no results found</h3>
                        <div id="welcome-panel" class="welcome-panel">
                            <div class="welcome-panel-content">
                                <br />
                                <div class="welcome-panel-column-container">
                                    <p class="about-description">It seems there are no IP Addresses registered in your database at the moment. Maybe I've done something wrong or you have missed some steps during setup.</p>
                                    <br />
                                    <p class="about-description">Please check if you have done the following</p>
                                    <br />
                                    <ul>
                                        <li>
                                            <span class="welcome-icon welcome-learn-more">
                                            Included the shortcode <code>[whohit]Page Name[/whohit]</code> on your pages. If not, click get started below. 
                                            </span>
                                        </li>
                                        <li><span class="welcome-icon welcome-learn-more">Imported all Geo Location data via the <a href="admin.php?page=whtp-import-export">Export/ Import</a> page.</span></li>
                                        <li><span class="welcome-icon welcome-learn-more">If you haven't done this, click "Get Started" below.</span></li>
                                    </ul>
                                    <a href="admin.php?page=whtp-help" class="button button-primary button-hero">Get Started</a>
                                </div>
                            </div>
                        </div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Wrap -->  
    <!-- Wrap -->
    <?php  
		}// if is admin
	}// if num_ips > 0
	
	/*
	*	Display a select for the user to select an IP
	*/
	function display_select_visitor_ip(){
		global $wpdb;
		$ip_results = $wpdb->get_results( "SELECT ip_address, ip_total_visits FROM whtp_hitinfo WHERE ip_status = 'active' ORDER BY ip_total_visits DESC" );
		if ( $ip_results ){
			$form = '<form name="select_ip" method="post" action="" >' . "\n";
			//$form .= "\t" . '<p>Please select an IP to see more details about that IP Address.</p>' . "\n";
			$form .= "\t" . '<select name="ip" style="height: 50px; width: 40%; padding: 15px;display: inline;">' . "\n";;
			foreach ( $ip_results as $ip ){
				$form .= "\t" . "\t" . '<option style="padding:15px; display: block; float: left;" value="' 
				. $ip->ip_address . '">' 
				. $ip->ip_address . ' (' 
				. $ip->ip_total_visits 
				. ')</option>' . "\n";	
			}	
			$form .= "\t" . '</select>' . "\n";
			$form .= "\t" . '<input style="display:inline;" type="submit" value="View Details" class="button button-primary button-hero" />'. "\n";
			$form .= '</form>' . "\n";	
		}else{
			$form .= $wpdb->print_error();	
		}
		
		$form .= '<div id="message" class="updated">
					<p>Please select an IP above to see more details about that IP Address.</p> 
				</div>';
		return $form;
	}
	/* 
	* End Functions
	*/

?>