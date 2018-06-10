<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WHTP_Deactivator extends WHTP_Database{
	public function __construct(){
		if( ! update_option( "whtp_installed", "false" )){ 
			add_option( "whtp_installed", "false", "", "yes" );
		}

		if ( get_option("whtp_data_action") == "delete-all"){
			self::delete_all();
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
	function empty_all(){
		global $wpdb;
		$wpdb->query ( "TRUNCATE `{self::$hits_table}`" 				);	
		$wpdb->query ( "TRUNCATE `{self::$hitinfo_table}`" 				);
		$wpdb->query ( "TRUNCATE `{self::$user_agents_table}`" 			);
		$wpdb->query ( "TRUNCATE `{self::$ip_hits_table}`" 				);
		$wpdb->query ( "TRUNCATE `{self::$visiting_countries_table}`" 	);
		$wpdb->query ( "TRUNCATE `{self::$ip2loacation_table}`"			);
	}
	
	/*
	* Delete all tables and their data
	*/
	function delete_all(){
		global $wpdb;
		$wpdb->query ( "DROP TABLE `{self::$hits_table}`" 				);
		$wpdb->query ( "DROP TABLE `{self::$hitinfo_table}`" 			);
		$wpdb->query ( "DROP TABLE `{self::$user_agents_table}`" 		);
		$wpdb->query ( "DROP TABLE `{self::$ip_hits_table}`" 		);
		$wpdb->query ( "DROP TABLE `{self::$visiting_countries_table}`" );
		$wpdb->query ( "DROP TABLE `{self::$ip2loacation_table}`" 		);
	}
}