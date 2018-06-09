<?php

abstract class WHTP_Database{
	private $hits_table;
	private $hitinfo_table;
	private $user_agents_table;
	private $ip_hits_table;
	private $visiting_countries_table;
	private $ip_to_loacation_table;
	private $ip_hits_table;

	private static $_instance = null;

	public static function get_instance() {
		if( is_null( self::$_instance ) ){
			self::$_instance = new Who_Hit_The_Page();
		}
		return self::$_instance;
	}

	public function __construct(){
		global $wpdb;

		self::$hits_table 				= $wpdb->prefix . 'whtp_hits';
		self::$hitinfo_table 			= $wpdb->prefix . 'whtp_hitinfo';
		self::$user_agents_table 		= $wpdb->prefix . 'whtp_user_agents';
		self::$ip_hits_table 			= $wpdb->prefix . 'whtp_ip_hits';
		self::$visiting_countries_table = $wpdb->prefix . 'whtp_visiting_countries';
		self::$ip2loacation_table 		= $wpdb->prefix . 'whtp_ip2location';
	}
}