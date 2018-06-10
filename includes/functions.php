<?php
	
class WHTP_Functions{
	
	public function __construct(){
		self::$hits_table 				= $wpdb->prefix . 'whtp_hits';
		self::$hitinfo_table 			= $wpdb->prefix . 'whtp_hitinfo';
		self::$user_agents_table 		= $wpdb->prefix . 'whtp_user_agents';
		self::$ip_hits_table 			= $wpdb->prefix . 'whtp_ip_hits';
		self::$visiting_countries_table = $wpdb->prefix . 'whtp_visiting_countries';
		self::$ip2loacation_table 		= $wpdb->prefix . 'whtp_ip2location';
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
	* get all IP addresses previously registered
	* get country_code for each ip and
	* add the country to the list of visiting countries
	*/ 
	public static function update_visiting_countries(){
		global $wpdb;
		 $ips = WHTP_Functions::all_ips();
		 for ( $count = 0; $count < count ( $ips ); $count ++ ){				
			$country_code = $wpdb->get_var( "SELECT country_code FROM whtp_ip2location WHERE INET_ATON('" . $ips[$count] . "') 
                    BETWEEN decimal_ip_from AND decimal_ip_to LIMIT 1" );
			
			$exists = $wpdb->get_var( "SELECT country_code FROM whtp_visiting_countries WHERE country_code='$country_code'" );
			
			if ( $exists ) {
				if ( $exists == "" ) {
					$wpdb->query ( "INSERT INTO whtp_visiting_countries (country_code, count) VALUES ('$country_code', 1)" );
				}
				else{
					$wpdb->query ( "UPDATE whtp_visiting_countries SET count=count+1 WHERE country_code='$country_code'" );
				}
			}
		 }
	}	
	
	/*
	* Return all ip addresse
	*
	*/
	public static function all_ips(){
		global $wpdb;
		$all_ips = array();
		$all_ips = $wpdb->get_col ( "SELECT ip_address FROM whtp_hitinfo" );		
		
		return $all_ips;
	}

	public function pagination( $number, $page, $total, $list_class ) {
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
	public static function whtp_admin_message_sender(){
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
}