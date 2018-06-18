<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}	
class WHTP_Functions{
	private static $hits_table;
	private static $hitinfo_table;
	private static $user_agents_table;
	private static $ip_hits_table;
	private static $visiting_countries_table;
	private static $ip_to_location_table;

	public function __construct(){
		self::$hits_table 				= $wpdb->prefix . 'whtp_hits';
		self::$hitinfo_table 			= $wpdb->prefix . 'whtp_hitinfo';
		self::$user_agents_table 		= $wpdb->prefix . 'whtp_user_agents';
		self::$ip_hits_table			= $wpdb->prefix . 'whtp_ip_hits';
		self::$visiting_countries_table = $wpdb->prefix . 'whtp_visiting_countries';
		self::$ip_to_location_table		= $wpdb->prefix . 'whtp_ip2location';
	}

	public static function plugin_info(){
		$plugin_data = get_plugin_data( __FILE__ );

		return $plugin_data;
	}

	public static function make_backup_dir (){
		$whtp_backup_dir =  WP_CONTENT_DIR . "/uploads/whtp_backups"; //always use wp_content_dir instead of _url
		if ( wp_mkdir_p ( $whtp_backup_dir ) ) {
			define( 'WHTP_BACKUP_DIR', $whtp_backup_dir );
			return true;
		}
		else{
			if ( mkdir ( $whtp_backup_dir ) ) {
				define( 'WHTP_BACKUP_DIR', $whtp_backup_dir );	
				return true;
			}
		}
		return false;
	}
	
	/*
	* Return all ip addresse
	*
	*/
	public static function all_ips(){
		global $wpdb;

		$all_ips = array();
		$all_ips = $wpdb->get_col ( "SELECT ip_address FROM `$hitinfo_table`" );		
		
		return $all_ips;
	}

	public static function paginate( $url, $page, $total, $number ){
		if( $page > 0 ) {
			$last = $page - 2;
			echo '<a href="$url?page='. $last . '&number=' . $number . '">' . __( "Last $number Records", "whtp") . '</a> |';
			echo '<a href="$url?page=' . $page . '">' . __( "Next $number Records", "whtp") . '</a>';
		}else if( $page == 0 ) {
			echo '<a href="$url?page=' . $page . '">' . __( "Next $number Records", "whtp") . '</a>';
		}else if( $left_rec < $rec_limit ) {
			$last = $page - 2;
			echo '<a href=$url?page=' . $last . '">' . __( "Last $number Records", "whtp") . '</a>';
		}
	}

	public static function pagination( $number, $page, $total, $list_class ) {
		if ( $number == 'all' ) {
			return '';
		}
	 
		$last       = ceil( $total / $number );
	 
		$start      = ( ( $page - $number ) > 0 ) ? $page - $number : 1;
		$end        = ( ( $page + $number ) < $last ) ? $page + $number : $last;
	 
		$html       = '<ul class="' . $list_class . '">';
	 
		$class      = ( $page == 1 ) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a href="?number=' . $number . '&page=' . ( $page - 1 ) . '">&laquo;</a></li>';
	 
		if ( $start > 1 ) {
			$html   .= '<li><a href="?number=' . $number . '&page=1">1</a></li>';
			$html   .= '<li class="disabled"><span>...</span></li>';
		}
	 
		for ( $i = $start ; $i <= $end; $i++ ) {
			$class  = ( $page == $i ) ? "active" : "";
			$html   .= '<li class="' . $class . '"><a href="?number=' . $number . '&page=' . $i . '">' . $i . '</a></li>';
		}
	 
		if ( $end < $last ) {
			$html   .= '<li class="disabled"><span>...</span></li>';
			$html   .= '<li><a href="?number=' . $number . '&page=' . $last . '">' . $last . '</a></li>';
		}
	 
		$class      = ( $page == $last ) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a href="?number=' . $number . '&page=' . ( $page + 1 ) . '">&raquo;</a></li>';
	 
		$html       .= '</ul>';
	 
		return $html;
	}

	/*
	* subscribe to plugin development
	* subscription sent from current admin, forward to developer's email address
	* Developer's email address hard coded below
	*/	
	public static function admin_message_sender(){
		$s_email = stripslashes($_POST['asubscribe_email']);
		if($s_email != ""){
			$s_email = $s_email;
		}
		else{
			$s_email = get_option('admin_email');
		}
		
		# try to get email address from MPMF if it is installed
		if ( $s_email == "" ){
			$mpmf_installed = get_option('mpmf_installed');
			if ( $mpmf_installed ) {
				if( get_option('mpmf_email_to_us') != "" && get_option('mpmf_email_to_us') != "Your receiving email address" ){
					# && $send_to_us != "Your receiving email address" && $send_to_us != ""
					$s_email = get_option('mpmf_email_to_us');
				}
			}
			else{
				$err_msg = "You did not give us an email address. Please enter your email address to subscribe to updates, we will send update notices to this email address.";	
			}
		}
		$headers = "";
		$headers .= "From: ". $s_email . "\r\n";
		$headers .= "Reply-To: ". $s_email . "\r\n";
		$headers .= "X-Mailer: PHP/" . phpversion();
		
		$message = "Subscribe me to `Who Hit The Page - Hit Counter` updates my email address is " . $s_email; 
		if ( $s_email == "" && $err_msg != "") {
			echo "<div class='error-msg'>Subscription message not sent $err_msg. Please enter email address and retry.</div>";
		}
		else{
			if(who_hit_send_email('himself@lindeni.co.za','Who Hit The Page - Hit Counter',$message,$headers)){
				echo "<div class='success-msg'>Your subscription has been submitted.</div>";
			}
			else{
				echo "<div class='error-msg'>Subscription message not sent. Please retry.</div>";
			}
		}	
	}
	# functions	
	/*
	* Email function to send an email
	*/
	public static function who_hit_send_email($user, $subject, $message, $headers){
		if(mail($user, $subject, $message, $headers)){
			return true;
		}
		else return false;
	}

	public static function signup_form() {
		echo '<form action="" method="post" id="signup">
			<input type="hidden" name="whtpsubscr" value="y" />
			<label for="asubscribe_email">Enter your email address to subscribe to updates</label>
			<input type="email" placeholder="e.g. ' . get_option('admin_email') .'" name="asubscribe_email" value="" class="90" /><br />
			<input type="submit" value="Subscribe to updates" class="button button-primary button-hero" />
		</form>';
	}

	public static function deny_wordpress_host_ip(){
	
		$local 		= $_SERVER['HTTP_HOST'];	# this host's name
		$siteurl 	= get_option('siteurl');	# wordpress site url
		$ref 		= $_SERVER['HTTP_REFERER']; # referrer host name	
		$rem 		= $_SERVER['REMOTE_ADDR'];  # visitor's ip address
		
		if ( isset ( $_SERVER['SERVER_ADDR'] ) ) {
			$local_addr	= $_SERVER['SERVER_ADDR'];  # this host's ip address
		}
		
		
		return $deny;
	}

	/*
	* $out = fopen('php://output','w'); to send output to the browser_id
	* Functions to import and export csv files
	*/
	public static function write_csv($file_name, array $list, $delimeter = ",", $enclosure = '"'){
		$handle = fopen( $file_name, "w" );	
		foreach ( $list as $fields ){
			if ( fputcsv ( $handle, $fields ) ) $done = true; // flag successful write
			else $done = false; // flag failed write
		}
		/*
		fputcsv( $out, $list );*/
		fclose( $handle );
		return $done; // return success or failed as true/false
	}
	
	
	/*
	* export the hits table to a CSV file
	* uses the function write_csv
	* returns the file's url and file name as an array
	*/
	public static function export_hits( $backup_date ){
		global $wpdb;

		$filename_url = WHTP_BACKUP_DIR;		
		$filename = $filename_url . "/" . $backup_date . "/whtp-hits.csv";
		$hits = $wpdb->get_results ( "SELECT * FROM `$hits_table`" );
		
		$fields = array(); // csv rows / whole document
		if ( count ( $hits ) ){			
			foreach ( $hits as $hit  ){				
				$csv_row  = array(
					$hit->page, 
					$hit->count_hits
				);	 // new row				
				$fields[] = $csv_row; // append row to others
			}
			//whtp_write_csv( $filename, $fields);
			if ( whtp_write_csv( $filename, $fields) ){
				$export_url = WP_CONTENT_URL . '/uploads/whtp_backups/' . $backup_date . "/whtp-hits.csv";
				echo '<p>Page "Hits" backup successful.</p>';
			}
		}
		return $recent_backup = array( 'link'=>$export_url, 'filename'=>'whtp-hits' );
		
	}
	
	/*
	* export the hitinfo table to a CSV file
	* uses the function write_csv
	* returns the file's url and file name as an array
	*/
	public static function export_hitinfo( $backup_date ){
		global $wpdb;

		$filename_url = WHTP_BACKUP_DIR;		
		$filename = $filename_url . "/" . $backup_date . "/whtp-hitinfo.csv";
		
		$hitsinfo = $wpdb->get_results ( "SELECT * FROM `$hitinfo_table`" );
		
		$fields = array(); // csv rows / whole document
		if ( count( $hitsinfo ) > 0 ){			
			foreach ( $hitsinfo as $hitinfo  ){
				$csv_row  = array(
					$hitinfo->ip_address,
					$hitinfo->ip_total_visits,
					$hitinfo->user_agent,
					$hitinfo->datetime_first_visit,
					$hitinfo->datetime_last_visit
				);	 // new row				
				$fields[] = $csv_row;	 // new row;				
			}
			if ( whtp_write_csv( $filename, $fields) ){
				$export_url = WP_CONTENT_URL . '/uploads/whtp_backups/' . $backup_date . "/whtp-hitinfo.csv";
				echo '<p>Hitinfo backup successful.</p>';
			}	
		}
		return $recent_backup = array( 'link'=>$export_url, 'filename'=>'whtp-hitinfo' );
	}
	
	/*
	* export the user_agents table to a CSV file
	* uses the function write_csv
	* returns the file's url and file name as an array
	*/
	public static function export_user_agents( $backup_date ){
		global $wpdb;
		
		$filename_url = WHTP_BACKUP_DIR;		
		$filename = $filename_url . "/" . $backup_date . "/whtp-user-agents.csv";
		
		$user_agents = $wpdb->get_results ( "SELECT * FROM `$user_agents_table`" );
		$fields = array();
		
		if ( count( $user_agents ) > 0 ){			
			foreach ( $user_agents as $user_agent  ){
				$csv_row  = array(
					$user_agent->agent_id,
					$user_agent->agent_name,
					$user_agent->agent_details
				);				
				$fields[] = $csv_row;
			}	
			// write to csv
			//whtp_write_csv( $filename, $fields);
			if ( whtp_write_csv( $filename, $fields) ){
				$export_url = WP_CONTENT_URL . '/uploads/whtp_backups/' . $backup_date . "/whtp-user-agents.csv";
				echo '<p>User Agents backup successful.</p>';
			}	
		}
		return $recent_backup = array( 'link'=>$export_url, 'filename'=>'whtp-user-agents' );	
	}
	
	/*
	* export the ip_hits table to a CSV file
	* uses the function write_csv
	* returns the file's url and file name as an array
	*/
	public static function export_ip_hits( $backup_date ){
		global $wpdb;

		$filename_url = WHTP_BACKUP_DIR;		
		$filename = $filename_url . "/" . $backup_date . "/whtp-ip-hits.csv";
		
		$ip_hits = $wpdb->get_results( "SELECT * FROM `$ip_hits_table`" );
		$fields = array();
		if ( count( $ip_hits ) > 0 ){			
			foreach ( $ip_hits as $ip_hit  ){
				$csv_row  = array(
					$ip_hit->ip_id,
					$ip_hit->page_id,
					$ip_hit->datetime_first_visit,
					$ip_hit->datetime_last_visit,
					$ip_hit->browser_id
				);
				$fields[] = $csv_row;
			}
			if ( whtp_write_csv( $filename, $fields, ',', '') ){
				$export_url = WP_CONTENT_URL . '/uploads/whtp_backups/' . $backup_date . "/whtp-ip-hits.csv";
				echo '<p>IP Hits Table backup successful.</p>';
			}	
		}
		return $recent_backup = array( 'link'=>$export_url, 'filename'=>'whtp-ip-hits' );
	}

	public static function log( $message ) {
		if ( defined('WHTP_LOG') && WHTP_LOG ) {
			$date = current_time( 'mysql' );
			if ( ! is_string( $message ) ) {
				$message = print_r( $message, true );
			}
			$message = '[' . $date . '] - ' . $message . "\n";
			file_put_contents( trailingslashit( WP_CONTENT_DIR ) . 'whtp-debug.log', $message, FILE_APPEND );
		}
	}
}