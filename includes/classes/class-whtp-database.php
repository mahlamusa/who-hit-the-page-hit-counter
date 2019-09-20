<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
abstract class WHTP_Database {

	public static $hits_table;
	public static $hitinfo_table;
	public static $user_agents_table;
	public static $ip_hits_table;
	public static $visiting_countries_table;
	public static $ip_to_location_table;

	private static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new Who_Hit_The_Page();
		}
		return self::$_instance;
	}

	public function __construct() {
		global $wpdb;

		self::$hits_table               = $wpdb->prefix . 'whtp_hits';
		self::$hitinfo_table            = $wpdb->prefix . 'whtp_hitinfo';
		self::$user_agents_table        = $wpdb->prefix . 'whtp_user_agents';
		self::$ip_hits_table            = $wpdb->prefix . 'whtp_ip_hits';
		self::$visiting_countries_table = $wpdb->prefix . 'whtp_visiting_countries';
		self::$ip_to_location_table     = $wpdb->prefix . 'whtp_ip2location';
	}
}
