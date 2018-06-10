<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_Ip_Hits extends WHTP_Database{
    public function __construct(){
        parent::__construct();
	}
	
	public static function ip_hit($ip_id,$page_id,$date_ftime,$ua_id){
        global $wpdb;

        $wpdb->insert(
            self::$ip_hits_table, 
            array(
                "ip_id"                 => $ip_id,
                "page_id"               => $page_id,
                "datetime_first_visit"  => $date_ftime,
                "browser_id"            => $ua_id
            ), array("%d","%d","%s","%d") 
        );
    }

    /*
	* Get all the ids of the browsers used by the user
	* Return as an array of agent_ids
	*/
	public static function agent_ids_from_ip_id( $ip_id ){
		global $wpdb;
		$agent_ids = array();
		$ids = $wpdb->get_col( "SELECT browser_id FROM whtp_ip_hits WHERE ip_id = '$ip_id'" );
		if ( count ( $ids ) ){			
			for( $count=0; $count < count ($ids); $count ++){
				if  ( !in_array( $ids[$count], $agent_ids )	){
					$agent_ids[] = $ids[$count];
				}
			}
		}
		return $agent_ids;
	}
	/*
	* Get all the ids of the pages visted by the user
	* Return as an array of page_ids
	*/
	public static function page_ids_from_ip_id($ip_id){
		global $wpdb;
		$results = $wpdb->get_col( "SELECT page_id FROM whtp_ip_hits WHERE ip_id = '$ip_id'" );
		if ($results){
			$page_ids = array();
			for( $count = 0; $count < count($results); $count ++ ){
				if  ( !in_array( $results[$count], $page_ids )	){
					$page_ids[] = $results[$count];
				}
			}
			return $page_ids;
		}
		return false;
	}
}