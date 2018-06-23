<?php
use MaxMind\Db\Reader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_IP2_Location{
    private static $ip_to_location_table;

    public function __construct(){
        global $wpdb;
        
        self::$ip_to_location_table	= $wpdb->prefix . 'whtp_ip2location';
    }

    /*
    *	Count country's visits
    */
    public static function get_country_code( $ip_address ){
        $results = self::get( $ip_address );

        if ( isset( $results[ 'country_code'] ) ) {
            return $country_code;
        }else{
            return "AA";
        } 
    }

    public static function get_country_name( $ip_address ){ 
        $results = self::get( $ip_address );

        if ( isset( $results[ 'country_name'] ) ) {
            return $country_name;
        }            
        else {
            return __( 'Unknown Country', 'whtp' );
        } 
    }

    public static function country_code_to_ip( $country_code ) {
        global $wpdb, $ip_to_location_table;

    }

    public static function get( $ip_address ){
        if ( $ip_address == null ) return array();

        require_once WHTP_PLUGIN_DIR_PATH . 'vendor/autoload.php';

        $databaseFile = WHTP_PLUGIN_DIR_PATH . 'geodata/GeoLite2-City.mmdb';

        $reader         = new Reader( $databaseFile );        
        $record         = $reader->get( $ip_address );
        $reader->close();

        return apply_filters( 'whtp_locate_ip', array(
            'country_code'  => $record['country']['iso_code'],
            'country_name'  => $record['country']['names']['en'],
            'continent_code' => $record['continent']['iso_code'],
            'continent_name' => $record['continent']['names']['en']
        ), $record);
    }
}