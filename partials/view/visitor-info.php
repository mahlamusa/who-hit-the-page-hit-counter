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
			$visitor_ip = stripslashes( $_GET['ip'] );
		}
		elseif( isset ( $_POST['ip'] ) ){
			$visitor_ip = esc_attr( $_POST['ip'] );			
		}		
		else {
            $visitor_ip = $_SERVER['REMOTE_ADDR'];
        }
        
        $ip_id = WHTP_Hit_Info::get_ip_id($visitor_ip);
			
		$info_result = array();
		$page_ids = array();
		$pages_visited = array();
		$agent_ids = array();
		$browsers = array();
		/*
		* Given the page ids, get the page names
		* save to array of pages and counts
		*/
		$page_ids = WHTP_Ip_Hits::page_ids_from_ip_id( $ip_id );
		
		foreach( $page_ids as $page_id ) {
            $page = WHTP_Hits::get_page_by_id( $page_id );
			$pages_visited[] = $page;
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
		$country_name = WHTP_IP2_Location::get_country_name( $visitor_ip );
		
		
		$agent_ids = WHTP_Ip_Hits::agent_ids_from_ip_id( $ip_id );
		
		/*
		*	Get browsers used
		*	returns an array of browsers
		*	pass an array of browser ids,you will get browsers with those ids
		*   pass an empty string, you get an array of all browsers ever used
		*/
		for ( $i = 0; $i < count( $agent_ids ); $i ++ ){
			$agent_id = $agent_ids[$i];
			$browser = WHTP_Browser::get_browser_name( $agent_id );
			if ( $browser ){
				$browsers[] = $browser;
			}
		}
		
	?>
<div class="mdl-grid whtps-content">
    <h2 class="mdl-card__title-text"><?php _e( 'Who Hit The Page Hit Counter', 'whtp' ); ?></h2>
    <div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
        <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <p><?php _e( 'To start viewing the details of a single visitor, select the visitor\'s IP below and click "View Details", do the same to view another IP.', 'whtp' ); ?></p>
                <?php
                    $ip_results = WHTP_Hit_Info::get_ip_count_hits();
                    if ( $ip_results ) : ?>
                        <form name="select_ip" method="post" action="" >
                            <p>Please select an IP to see more details about that IP Address.</p>
                            <select name="ip" class="whtp-select-single" style="width: 40%; padding: 5px;display: inline;"><?php
                                foreach ( $ip_results as $ip ) : ?>
                                    <option style="padding:15px; display: block; float: left;" 
                                        value="<?php echo esc_attr( $ip->ip_address ); ?>">
                                            <?php echo esc_attr( $ip->ip_address . ' (' . $ip->ip_total_visits . ')' 
                                    ); ?>
                                    </option><?php
                                endforeach;	?>
                            </select>
                            <input style="display:inline;" type="submit" value="<?php _e( 'View Details', 'whtp' ); ?>" class="button button-primary mdl-button mdl-js-button mdl-js-ripple-effect" />
                        </form><?php	
                    endif; ?>
                    
                    <p><?php _e( 'Please select an IP above to see more details about that IP Address.', 'whtp' ); 
                ?>
            </div>
        </div>  
    </div>
	<h3><?php _e( 'View Visitor\'s Behaviour (IP:', 'whtp' ); ?> <?php echo $visitor_ip; ?>)</h3>
    
    <div class="mdl-color--white mdl-cell mdl-cell--6-col">
        <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <?php _e( 'Visitor Statistics!', 'whtp' ); ?>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <?php echo sprintf( __( 'This are the statistics for a single user/visitor with IP Address :', 'whtp' ), $visitor_ip ); ?>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <?php echo sprintf( __( 'Visitor\'s IP: %s', 'whtp' ), !$visitor_ip ? "IP Address Not Set": $visitor_ip ); ?>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <?php echo sprintf( __( 'Total Visits: %s', 'whtp' ), !$info_result? "Not Set" : $info_result->ip_total_visits ); ?>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <?php echo sprintf( __( 'Location: %s', 'whtp' ), $country_name ); ?>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <?php _e( 'First Visit :', 'whtp' ); ?> <?php echo $info_result->datetime_first_visit; ?>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <?php _e( 'Last Visit : ', 'whtp' ); ?><?php echo $info_result->datetime_last_visit; ?>
            </div>            
        </div>  
    </div>

    <div class="mdl-color--white mdl-cell mdl-cell--6-col">
        <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <?php _e( 'Browsers & Pages!', 'whtp' ); ?>
            </div>            
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <strong><?php _e( 'Pages Visited by this user', 'whtp' ); ?></strong>
            </div>
            <?php
                if ( ! $pages_visited || count( $pages_visited ) <= 0 ): ?>
                    <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                        <?php _e( 'No Pages Visited', 'whtp' ); ?>
                    </div><?php
                else:
                    foreach ( $pages_visited as $page): ?>
                        <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                            <a href="#" class="welcome-icon welcome-view-site">
                                <?php echo $page->page . '('. $page->count_hits . ')'; ?>
                            </a>
                        </div><?php	
                    endforeach;
                endif;
            ?>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <strong><?php _e( 'The User Has The following Browsers', 'whtp' ); ?></strong>
            </div>
            <?php
                if ( !$browsers || 0 == count( $browsers )): ?>
                    <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                        <?php _e('No Browser(s)', 'whtp'); ?>
                    </div><?php
                else:
                    for ( $i = 0; $i< count( $browsers ); $i ++): ?>
                        <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                            <?php echo $browsers[$i]; ?>
                        </div><?php       
                    endfor;
                endif;
            ?>
        </div>  
    </div>

    <div class="mdl-color--white mdl-cell mdl-cell--12-col">
        <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <?php _e( 'Disclaimer', 'whtp' ); ?>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <?php require_once( WHTP_PLUGIN_DIR_PATH . 'partials/disclaimer.php' ); ?>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Read More</a>
            </div>
        </div>  
    </div>
</div>

    <?php
    }
    /*
    * else there are no ips to show stats for
    * display a message for the user to visit how to get started/help page
    */
    else{ 
    
        if ( is_admin() ) { ?>

        <div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
        <div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <h2 class="mdl-card__title-text">
                <?php _e( 'Sorry no results found', 'whtp' ); ?>
                </h2>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                <p class="about-description">
                    <?php _e( 'It seems there are no IP Addresses registered in your database at the moment. Maybe I\'ve done something wrong or you have missed some steps during setup.', 'whtp' ); ?>
                </p>
                <br />
                <p class="about-description">
                    <?php _e( 'Please check if you have done the following', 'whtp' ); ?>
                </p>
                <br />
                <ul>
                    <li>
                        <span class="welcome-icon welcome-learn-more">
                            <?php _e( 'Included the shortcode <code>[whohit]Page Name[/whohit]</code> on your pages. If not, click get started below.', 'whtp' ); ?> 
                        </span>
                    </li>
                    <li>
                        <span class="welcome-icon welcome-learn-more">
                            <?php _e( 'Imported all Geo Location data via the <a href="admin.php?page=whtp-import-export">Export/ Import</a> page.', 'whtp' ); ?>
                        </span>
                    </li>
                    <li>
                        <span class="welcome-icon welcome-learn-more">
                            <?php _e( 'If you haven\'t done this, click "Get Started" below.', 'whtp' ); ?>
                        </span>
                    </li>
                </ul>
                <a href="admin.php?page=whtp-help" class="button button-primary button-hero">
                    <?php _e( 'Get Started', 'whtp' ); ?>
                </a>
            </div>
        </div>  
    </div>
    <?php  
		}// if is admin
	}// if num_ips > 0
?>