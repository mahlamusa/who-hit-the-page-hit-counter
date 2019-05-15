<?php
use MaxMind\Db\Reader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hit information class.
 */
class WHTP_Hit_Info {

	/**
	 * Table name to store the information.
	 *
	 * @var string $hitinfo_table
	 */
	private static $hitinfo_table;

	/**
	 * Constructor function.
	 */
	public function __construct() {
		global $wpdb;

		self::$hitinfo_table = $wpdb->prefix . 'whtp_hitinfo';
	}

	/**
	 * Get info given some parameters.
	 *
	 * @param integer $offset
	 * @param integer $number
	 * @param string  $status
	 * @return void
	 */
	public static function get_hitinfo( $offset = 0, $number = 15, $status = 'active' ) {
		global $wpdb, $hitinfo_table;

		$sql = "SELECT * FROM `$hitinfo_table` 
        WHERE ip_status='$status' 
        ORDER BY ip_total_visits DESC";

		if ( self::count() > $number ) {
			$sql = ( $number != 'all' ) ? $sql . " LIMIT $offset, $number" : $sql;
		}

		$hits = $wpdb->get_results( $sql );

		if ( $hits ) {
			return $hits;
		} else {
			return array();
		}
	}

	/**
	 * Count hit info.
	 *
	 * @param string $status
	 * @return void
	 */
	public static function count( $status = 'active' ) {
		global $wpdb, $hitinfo_table;

		$count = $wpdb->get_var( "SELECT COUNT(ip_address) FROM `$hitinfo_table` WHERE ip_status='{$status}'" );

		if ( $count ) {
			return $count;
		} else {
			return 0;
		}
	}

	/*
	* Get entries from old hitinfo table.
	* count the existing ips into the country count.
	*/
	public static function update_count_visiting_countries() {
		global $wpdb, $hitinfo_table;

		$ips = $wpdb->get_results( "SELECT ip_address FROM `$hitinfo_table` WHERE ip_status = 'active'" );
		if ( $ips ) {
			foreach ( $ips as $ip ) {
				$country_code = WHTP_IP2_Location::get_country_code( $ip->ip_address );
				if ( WHTP_Visiting_Countries::country_count( $country_code ) ) {
					return true;
				} else {
					return false;
				}
			}
		}

		return false;
	}

	/**
	 * Get IP id given address.
	 *
	 * @param [type] $ip_address
	 * @return void
	 */
	public static function get_ip_id( $ip_address ) {
		global $wpdb, $hitinfo_table;

		$ip_id = $wpdb->get_var( "SELECT id FROM `$hitinfo_table` WHERE ip_address='$ip_address' LIMIT 1" );
		if ( $ip_id ) {
			return $ip_id;
		}
	}

	/**
	 * Reset IP information.
	 *
	 * @param string  $ip_address
	 * @param integer $which
	 * @return void
	 */
	public static function reset_ip_info( $ip_address = '', $which = 1 ) {
		global $wpdb, $hitinfo_table;

		if ( $which != 'all' && isset( $ip_address ) ) {
			$reset = $wpdb->update(
				$hitinfo_table,
				array( 'ip_total_visits' => 0 ),
				array( 'ip_address' => $ip_address ),
				array( '%d' ),
				array( '%s' )
			);
		} else {
			$reset_all = $wpdb->query( "UPDATE `$hitinfo_table` SET ip_total_visits = 0" );
		}

		if ( isset( $reset ) && $reset || isset( $reset_all ) && $reset_all ) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Delete IP address.
	 *
	 * @param string  $ip_address
	 * @param integer $which
	 * @return void
	 */
	public static function delete_ip( $ip_address = '', $which = 1 ) {
		global $wpdb, $hitinfo_table;

		if ( $which != 'all' && $ip_address != '' ) {
			$del = $wpdb->query( "DELETE FROM `$hitinfo_table` WHERE ip_address='$ip_address'" );
		} else {
			$del = $wpdb->query( "DELETE FROM `$hitinfo_table`" );
		}

		if ( $del ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get hits for IP.
	 *
	 * @param  string $visitor_ip
	 * @return void
	 */
	public static function hits_for_ip( $visitor_ip ) {
		global $wpdb, $hitinfo_table;

		return $wpdb->get_row(
			"SELECT * FROM `$hitinfo_table` 
            WHERE ip_address='$visitor_ip'"
		);
	}

	/**
	 * Get ip count hits.
	 *
	 * @return void
	 */
	public static function get_ip_count_hits() {
		global $wpdb, $hitinfo_table;

		return $wpdb->get_results(
			"SELECT ip_address, ip_total_visits 
            FROM $hitinfo_table 
            WHERE ip_status = 'active' 
            ORDER BY ip_total_visits DESC"
		);
	}

	/**
	 * Count unique hits.
	 *
	 * @return void
	 */
	public static function count_unique() {
		global $wpdb, $hitinfo_table;

		return $wpdb->get_var(
			"SELECT COUNT(ip_address) AS totalunique 
            FROM `$hitinfo_table` 
            WHERE ip_status='active'"
		);
	}

	/**
	 * Get top hits.
	 *
	 * @param integer $number
	 * @return void
	 */
	public static function top( $number = 10 ) {
		global $wpdb, $hitinfo_table;

		return $wpdb->get_results(
			"SELECT ip_address, ip_total_visits 
            FROM `$hitinfo_table` 
            WHERE ip_status='active' 
            ORDER BY ip_total_visits DESC LIMIT $number"
		);
	}

	/**
	 * Check if IP is denied.
	 *
	 * @param [type] $ip_address
	 * @return void
	 */
	public static function ip_is_denied( $ip_address ) {
		global $wpdb, $hitinfo_table;
		$denied_ip = $wpdb->get_var(
			"SELECT ip_address 
            FROM `$hitinfo_table` 
            WHERE ip_status='denied' AND ip_address='$ip_address' 
            LIMIT 1"
		);

		if ( $denied_ip && $denied_ip != '' ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Set an IP's status as denied
	 *
	 * @param [type] $ip_address
	 * @return void
	 */
	public static function deny_ip( $ip_address ) {
		global $wpdb, $hitinfo_table;

		$deny = $wpdb->update(
			$hitinfo_table,
			array( 'ip_status' => 'denied' ),
			array( 'ip_address' => $ip_address ),
			array( '%s' ),
			array( '%s' )
		);

		if ( $deny ) {
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Add denied IP.
	 *
	 * @param  string $ip_address
	 * @return void
	 */
	public static function add_denied_ip( $ip_address ) {
		global $wpdb, $hitinfo_table;

		$add_ip = $wpdb->insert(
			$hitinfo_table,
			array(
				'ip_status'  => 'denied',
				'ip_address' => $ip_address,
			),
			array( '%s', '%s', '%s' )
		);

		if ( $add_ip ) {
			return true;
		} else {
			return false;
		}
	}

	public static function allow_ip( $ip_address ) {
		global $wpdb, $hitinfo_table;

		$allow = $wpdb->update(
			$hitinfo_table,
			array( 'ip_status' => 'active' ),
			array( 'ip_address' => $ip_address ),
			array( '%s' ),
			array( '%s' )
		);

		if ( $allow ) {
			return true;
		} else {
			return false;
		}
	}

	/*
	* Start gathering unique user data
	* and update the table
	*/
	public static function hit_info( $page ) {
		global $wpdb, $hitinfo_table;

		$page = $page;

		$ip_address = WHTP_IP2_Location::get_ip_address();    // visitor's ip address
		$date_ftime = date( 'Y/m/d H:i:s', current_time( 'timestamp', 0 ) ); // visitor's first visit
		$date_ltime = date( 'Y/m/d H:i:s', current_time( 'timestamp', 0 ) ); // visitor's last visit

		// MaxMind GeoIP2
		include_once WHTP_PLUGIN_DIR_PATH . 'vendor/autoload.php';

		$databaseFile = WHTP_PLUGIN_DIR_PATH . 'geodata/GeoLite2-City.mmdb';

		$reader = new Reader( $databaseFile );
		$record = $reader->get( $ip_address );
		if ( $record ) {
			$country_code   = $record['country']['iso_code'];
			$country_name   = $record['country']['names']['en'];
			$continent_code = $record['continent']['code'];
			$continent_name = $record['continent']['names']['en'];
		} else {
			$country_code   = __( 'AA', 'whtp' );
			$country_name   = __( 'Unknown Country', 'whtp' );
			$continent_code = __( 'AA', 'whtp' );
			$continent_name = __( 'Unknown Continent' . 'whtp' );
		}

		$reader->close();

		// $ua = getBrowser(); //Get browser info
		$ua      = WHTP_Browser::browser_info();
		$browser = $ua['name'];

		$page_id = WHTP_Hits::get_page_id( $page );
		/*
		* first check if the IP is in database
		* if the ip is not in the database, add it in
		* otherwise update
		*/

		$ip_check = $wpdb->get_var( "SELECT ip_address FROM `$hitinfo_table` WHERE ip_address = '$ip_address'" );

		if ( $ip_check == '' ) {
			$insert_hit_info = $wpdb->insert(
				$hitinfo_table,
				array(
					'ip_address'           => $ip_address,
					'ip_total_visits'      => 1,
					'user_agent'           => $browser,
					'datetime_first_visit' => $date_ftime,
					'datetime_last_visit'  => $date_ltime,
				),
				array( '%s', '%d', '%s', '%s', '%s' )
			);

			$ip_id = $wpdb->insert_id;
		} else {
			$ip_total_visits = $wpdb->get_var( "SELECT ip_total_visits FROM `$hitinfo_table` WHERE ip_address = '$ip_address'" );

			$ip_total_visits += 1;
			$update_ip_visit  = $wpdb->update(
				$hitinfo_table,
				array(
					'ip_total_visits'     => $ip_total_visits,
					'user_agent'          => $browser,
					'datetime_last_visit' => $date_ltime,
				),
				array( 'ip_address' => $ip_address ),
				array( '%d', '%s', '%s' )
			);
		}

		$ua_id = WHTP_Browser::get_agent_id( $browser );
		$ip_id = self::get_ip_id( $ip_address );

		if ( ! WHTP_Browser::browser_exists( $browser ) ) {
			WHTP_Browser::add_browser( $browser );
		}

		if ( ! is_wp_error( $page_id ) ) {
			WHTP_Ip_Hits::ip_hit( $ip_id, $page_id, $date_ftime, $ua_id ); // insert new hit
		}

		// get the country code corresponding to the visitor's IP
		// $country_code   = WHTP_IP2_Location::get_country_code( $ip_address );
		$counted = WHTP_Visiting_Countries::country_count( $country_code, $country_name );
	}
}
