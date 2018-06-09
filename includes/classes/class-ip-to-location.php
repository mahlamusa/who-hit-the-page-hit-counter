<?php

class WHTP_IP_Location extends WHTP_Database{
    public function __construct(){
        parent::__construct();
    }

    /*
    *	Count country's visits
    */
    function get_country_code( $visitor_ip ){
        global $wpdb;
        $select_country_code = "SELECT country_code 
            FROM `" . self::$ip2loacation_table  . "`
            WHERE INET_ATON('" . $visitor_ip . "') 
            BETWEEN decimal_ip_from AND decimal_ip_to LIMIT 1";

        $country_code = $wpdb->get_var( $select_country_code );
        
        if ( $country_code ){		
            return $country_code;
        }	
        else return "AA";
    }
}