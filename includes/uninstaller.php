<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WHTP_Deactivator{
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
		

		if ( get_option("whtp_data_action") == "delete-all"){
			self::delete_all();
			if( ! update_option( "whtp_installed", "no" ) ){ 
				add_option( "whtp_installed", "no" );
			}
		}
		elseif( get_option("whtp_data_action") == "clear-tables"){
			self::empty_all();
		}
		else {};
	}

	/*
	* Delete all data / Empty all tables
	* leave table structures
	*/
	public static function empty_all(){
		global $wpdb;
		$wpdb->query ( "TRUNCATE `" . self::$hits_table . "`" 				);	
		$wpdb->query ( "TRUNCATE `" . self::$hitinfo_table . "`" 			);
		$wpdb->query ( "TRUNCATE `" . self::$user_agents_table . "`" 		);
		$wpdb->query ( "TRUNCATE `" . self::$ip_hits_table . "`" 			);
		$wpdb->query ( "TRUNCATE `" . self::$visiting_countries_table . "`" );
		$wpdb->query ( "TRUNCATE `" . self::$ip_to_location_table . "`"	);
	}
	
	/*
	* Delete all tables and their data
	*/
	public static function delete_all(){
		global $wpdb;
		$wpdb->query ( "DROP TABLE `" . self::$hits_table . "`" 			);
		$wpdb->query ( "DROP TABLE `" . self::$hitinfo_table . "`" 			);
		$wpdb->query ( "DROP TABLE `" . self::$user_agents_table . "`" 		);
		$wpdb->query ( "DROP TABLE `" . self::$ip_hits_table . "`" 			);
		$wpdb->query ( "DROP TABLE `" . self::$visiting_countries_table . "`");
		$wpdb->query ( "DROP TABLE `" . self::$ip_to_location_table . "`" 	);
	}
}