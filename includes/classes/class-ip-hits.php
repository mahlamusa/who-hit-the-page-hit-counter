<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_Ip_Hits {

	private static $ip_hits_table;

	public function __construct() {
		global $wpdb;

		self::$ip_hits_table = $wpdb->prefix . 'whtp_ip_hits';
	}

	public static function ip_hit( $ip_id, $page_id, $date_ftime, $ua_id ) {
		global $wpdb, $ip_hits_table;

		$wpdb->insert(
			$ip_hits_table,
			array(
				'ip_id'                => $ip_id,
				'page_id'              => $page_id,
				'datetime_first_visit' => $date_ftime,
				'browser_id'           => $ua_id,
			),
			array( '%d', '%d', '%s', '%d' )
		);
	}

	/*
	* Get all the ids of the browsers used by the user
	* Return as an array of agent_ids
	*/
	public static function agent_ids_from_ip_id( $ip_id ) {
		global $wpdb, $ip_hits_table;

		$agent_ids = array();
		$ids       = $wpdb->get_col( "SELECT browser_id FROM `$ip_hits_table` WHERE ip_id = '$ip_id'" );
		if ( count( $ids ) ) {
			for ( $i = 0; $i < count( $ids ); $i ++ ) {
				if ( ! in_array( $ids[ $i ], $agent_ids ) ) {
					$agent_ids[] = $ids[ $i ];
				}
			}
		}
		return $agent_ids;
	}
	/*
	* Get all the ids of the pages visted by the user
	* Return as an array of page_ids
	*/
	public static function page_ids_from_ip_id( $ip_id ) {
		global $wpdb, $ip_hits_table;

		$results = $wpdb->get_col( "SELECT page_id FROM `$ip_hits_table` WHERE ip_id = '$ip_id'" );
		if ( $results ) {
			$page_ids = array();
			for ( $i = 0; $i < count( $results ); $i ++ ) {
				if ( ! in_array( $results[ $i ], $page_ids ) ) {
					$page_ids[] = $results[ $i ];
				}
			}
			return $page_ids;
		}
		return false;
	}
}
