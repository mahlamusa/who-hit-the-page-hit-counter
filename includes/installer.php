<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_Installer{
	private static $hits_table;
	private static $hitinfo_table;
	private static $user_agents_table;
	private static $ip_hits_table;
	private static $visiting_countries_table;
	private static $ip_to_location_table;

	public function __construct(){
		global $wpdb;

		/**self::$hits_table 				= $wpdb->prefix . 'whtp_hits';
		self::$hitinfo_table 			= $wpdb->prefix . 'whtp_hitinfo';
		self::$user_agents_table 		= $wpdb->prefix . 'whtp_user_agents';
		self::$ip_hits_table			= $wpdb->prefix . 'whtp_ip_hits';
		self::$visiting_countries_table = $wpdb->prefix . 'whtp_visiting_countries';
		self::$ip_to_location_table	= $wpdb->prefix . 'whtp_ip2location';**/

		require_once( 'config.php' );

		/*
		* define backup directory
		*/
		if ( ! defined ( 'WHTP_BACKUP_DIR' ) ){
			WHTP_Functions::make_backup_dir ();
		}

		if ( ! defined( 'WHTP_VERSION') ) define( 'WHTP_VERSION', '1.4.6');

		self::upgrade_db();

		if ( ! self::is_installed() ) {			
			self::create();
		}		

		if ( ! get_option( 'whtp_version' ) ) {	
			update_option( 'whtp_version', WHTP_VERSION );						
		}

		if ( get_option( 'whtp_count_renamed', 'no' ) != 'yes' && version_compare( get_option( 'whtp_version' ), '1.4.6', '<' ) ) {
			self::update_count();
		}		
	}

	public static function is_installed(){
		if ( get_option('whtp_installed') == "yes" ) return true;
		else return false;
	}

	public static function create(){
		self::create_hits_table();
		self::create_hitinfo_table();
		self::create_visiting_countries();
		self::create_user_agents();
		self::create_ip_2_location_country();
		self::create_ip_hits_table();

		update_option( 'whtp_installed', "yes");
	}

	public static function upgrade_db(){
		self::check_rename_tables();
		self::update_old_user_agents();
		WHTP_Visiting_Countries::update_visiting_countries();		
	}

	public static function update_count(){
		if ( ! WHTP_Hits::count_exists() || ! WHTP_Visiting_Countries::count_exists() ) return;

		global $wpdb;
		if ( ! WHTP_Hits::count_exists() ) {
			$updated_hits = $wpdb->query("UPDATE `{$wpdb->prefix}whtp_hits` SET `count_hits`=`count`");
			if ( $updated_hits ) {
				$updated_hits = $wpdb->query("ALTER TABLE `{$wpdb->prefix}whtp_hits` DROP COLUMN count");
			}
		}
		
		if ( ! WHTP_Visiting_Countries::count_exists() ) {
			$updated_countries = $wpdb->query("UPDATE `{$wpdb->prefix}whtp_visiting_countries` SET `count_hits`=`count`");
			if ( $updated_countries ) {
				$updated_countries = $wpdb->query("ALTER TABLE `{$wpdb->prefix}whtp_visiting_countries` DROP COLUMN count");
			}
		}
	}

	public static function check_rename_tables(){
		if ( self::table_exists("hits") && ! self::table_exists( WHTP_HITS_TABLE ) ){
			self::rename_table("hits", WHTP_HITS_TABLE);
		}

		if ( self::table_exists( "hitinfo" ) && ! self::table_exists( WHTP_HITINFO_TABLE ) ) { 
			self::rename_table("hitinfo", WHTP_HITINFO_TABLE );
		}

		if ( self::table_exists( 'whtp_hits' ) && ! self::table_exists( WHTP_HITS_TABLE  ) ) { 
			self::rename_table( 'whtp_hits' , WHTP_HITS_TABLE );
		}

		if ( self::table_exists( 'whtp_hitinfo' ) && ! self::table_exists( WHTP_HITINFO_TABLE  ) ) { 
			self::rename_table( 'whtp_hitinfo', WHTP_HITINFO_TABLE );
		}

		if ( self::table_exists( 'whtp_user_agents' ) && ! self::table_exists( WHTP_USER_AGENTS_TABLE  ) ) { 
			self::rename_table( 'whtp_user_agents', WHTP_USER_AGENTS_TABLE );
		}

		if ( self::table_exists( 'whtp_ip_hits' ) && ! self::table_exists( WHTP_IP_HITS_TABLE ) ) { 
			self::rename_table( 'whtp_ip_hits' , WHTP_IP_HITS_TABLE );
		}

		if ( self::table_exists( 'whtp_visiting_countries' ) && ! self::table_exists( WHTP_VISITING_COUNTRIES_TABLE ) ) { 
			self::rename_table( 'whtp_visiting_countries', WHTP_VISITING_COUNTRIES_TABLE );
		}

		if ( self::table_exists( 'whtp_ip2location' ) && ! self::table_exists( WHTP_IP2_LOCATION_TABLE  ) ) { 
			self::rename_table( 'whtp_ip2location', WHTP_IP2_LOCATION_TABLE );
		}
	}

	public static function rename_table( $old_table_name, $new_table_name ){
		global $wpdb;		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		if ( $wpdb->query( "RENAME TABLE `" .  $old_table_name . "` TO `" . $new_table_name ."`;" ) ){
			return true;
		}
		else return false;
	}

	/*
	* Update old user agents into browser names
	*/
	public static function update_old_user_agents(){
		set_time_limit( 0 );
		global $wpdb;
			
		$user_agents = $wpdb->get_results( "SELECT ip_address, user_agent FROM ". WHTP_HITINFO_TABLE );
		if ( count( $user_agents ) > 0 ){
			foreach ( $user_agents as $uagent ) {
				$ua = WHTP_Browser::browser_info();
				$browser = $ua['name'];
				$ip = $uagent->ip_address;
				if ( $uagent->user_agent != $browser ){
					$update_browser = $wpdb->update(
						WHTP_HITINFO_TABLE, 
						array( "user_agent" => $browser ),
						array("ip_address"=>$ip),
						array("%s","%s")
					);
				}
			}
		}
	}

	# create hits table
	public static function create_hits_table(){
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		global $charset_collate;
		dbDelta("CREATE TABLE `" . WHTP_HITS_TABLE ."` (
			`page_id` int(10) NOT NULL AUTO_INCREMENT,
			`page` varchar(100) NOT NULL,
			`count_hits` int(15) DEFAULT 0,
			PRIMARY KEY (`page_id`)
			) $charset_collate;"
		);
	}
	# create hitinfo table
	public static function create_hitinfo_table(){
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		global $charset_collate;
		dbDelta("CREATE TABLE `" . WHTP_HITINFO_TABLE . "` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`ip_address` varchar(30) DEFAULT NULL,
			`ip_status` varchar(10) NOT NULL DEFAULT 'active',
			`ip_total_visits` int(15) DEFAULT '0',
			`user_agent` varchar(50) DEFAULT NULL,
			`datetime_first_visit` varchar(25) DEFAULT NULL,
			`datetime_last_visit` varchar(25) DEFAULT NULL,
			PRIMARY KEY (`id`)
			) $charset_collate;"
		);
	}

	public static function create_visiting_countries(){		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		global $charset_collate;
		dbDelta("CREATE TABLE `" . WHTP_VISITING_COUNTRIES_TABLE . "` (
			`country_code` char(2) NOT NULL,
			`country_name` varchar(125) DEFAULT NULL,
			`count_hits` int(11) NOT NULL,
			UNIQUE KEY `country_code` (`country_code`)
			) $charset_collate;"
		);
	}


	public static function create_ip_hits_table(){
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		global $charset_collate;
		dbDelta("CREATE TABLE `" . WHTP_IP_HITS_TABLE . "` (
			`id` int(10) NOT NULL AUTO_INCREMENT,
			`ip_id` int(11) NOT NULL,
			`page_id` int(10) NOT NULL,
			`datetime_first_visit` datetime NOT NULL,
			`datetime_last_visit` datetime NOT NULL,
			`browser_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
			) $charset_collate;"
		);
	}
	/*
	* Create user agents table
	*/
	public static function create_user_agents(){
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		global $charset_collate;
		dbDelta("CREATE TABLE `" . WHTP_USER_AGENTS_TABLE . "` (
			`agent_id` int(11) NOT NULL AUTO_INCREMENT,
			`agent_name` varchar(20) NOT NULL,
			`agent_details` text NOT NULL,
			PRIMARY KEY (`agent_id`),
			UNIQUE KEY `agent_name` (`agent_name`)
			) $charset_collate;"
		);
	}

	public static function create_ip_2_location_country(){		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		global $charset_collate;
		dbDelta("CREATE TABLE `" . WHTP_IP2_LOCATION_TABLE . "`(
			`ip_from` varchar(15) DEFAULT NULL,
			`ip_to` varchar(15) DEFAULT NULL,
			`decimal_ip_from` int(11) NOT NULL,
			`decimal_ip_to` int(11) NOT NULL,
			`country_code` char(2) DEFAULT NULL,
			`country_name` varchar(64) DEFAULT NULL,
			KEY `idx_ip_from` (`ip_from`),
			KEY `idx_ip_to` (`ip_to`),
			KEY `idx_ip_from_to` (`ip_from`,`ip_to`)
			) $charset_collate;"
		);
	}

	/*
	* Functions to export the old `hits` and `hitinfo` tables to the new `whtp_hits` and `whtp_hitinfo` tables
	* First run the function `whtp_table_exists()` to check if the table exists, then
	* Start the export if both the source and destination tables exists
	* If the destinatio table doesn't exist, create it and run the export again
	*/

	# check if a table exists in the database
	public static function table_exists ( $tablename ){
		global $wpdb;		
		$table = $wpdb->get_results("DESCRIBE `{$tablename}`;");

		if ( ! empty( $table ) && is_array( $table ) ) return true;
		else return false; 
	}

	# export hits data to whtp_hits
	public static function export_hits(){
		global $wpdb;

		$wpdb->hide_errors();
		
		$hits = $wpdb->get_results("SELECT * FROM `hits`, ARRAY_A");
		if ( count( $hits ) > 0){
			$message = "";
			$exported = false;
			foreach( $hits as $hit ){
				$insert = $wpdb->insert(
					WHTP_HITS_TABLE, 
					array(
						"page"=>$hit['page'], "count_hits" => $hit['count_hits']
					), array("%s", "%d")
				);
				if( !$insert ){
					$exported = false;
				}else{
					$exported = true;
				}
			}		
		}
		if ($exported == true) {
			$wpdb->query( "DROP TABLE IF EXISTS `hits`" );
		}
	}

	#export hitinfo data to whtp_hitinfo table
	public static function export_hitinfo(){
		global $wpdb;
		$wpdb->hide_errors();
		
		$hitsinfo = $wpdb->get_results("SELECT * FROM hitinfo");

		if( count( $hitsinfo ) > 0){
			$message 	= "";
			$exported	= false;
			foreach( $hitsinfo as $info ){	
				$insert = $wpdb->insert(
					WHTP_HITINFO_TABLE, 
					array(
						"ip_address"=>$info->ip_address,
						"ip_status"=>'active',
						"user_agent"=>$info->user_agent,
						"datetime_first_visit"=>$info->datetime,
						"datetime_last_visit"=>$info->datetime
					), 
					array("%s","%s","%s","%s","%s") 
				);
				if ( ! $insert ){
					$exported = false;
				}
				else{
					$exported = true;
				}
			}
		}
		
		if ( $exported == true) {
			$wpdb->query("DROP TABLE IF EXISTS `hitinfo`");
		}
	}
}