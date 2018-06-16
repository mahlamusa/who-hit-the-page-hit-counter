<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_IP_Location{
    private static $ip_to_location_table;

    public function __construct(){
        global $wpdb;
        
        self::$ip_to_location_table	= $wpdb->prefix . 'whtp_ip2location';
    }

    public static function load(){
        
    }

    /*
    *	Count country's visits
    */
    public static function get_country_code( $visitor_ip ){
        global $wpdb, $ip_to_location_table;
        
        $select_country_code = "
            SELECT country_code 
            FROM `$ip_to_location_table`
            WHERE INET_ATON('$visitor_ip') 
            BETWEEN decimal_ip_from AND decimal_ip_to LIMIT 1";

        $country_code = $wpdb->get_var( $select_country_code );
        
        if ( $country_code ){		
            return $country_code;
        }	
        else return "AA";
    }

    public static function get_country_name( $country_code ){
        global $wpdb, $ip_to_location_table;
        
		$country_name = $wpdb->get_var(
            "SELECT country_name FROM `$ip_to_location_table` 
            WHERE country_code='$country_code' LIMIT 0,1"
        );
        
		if ( $country_name == "") return "Unknown Country";
		else return $country_name;
    }
}