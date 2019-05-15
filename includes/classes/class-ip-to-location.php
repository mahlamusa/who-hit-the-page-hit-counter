<?php
use MaxMind\Db\Reader;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_IP2_Location {

	private static $ip_to_location_table;

	/**
	 * Current user's location data
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private static $location = null;

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {
		self::$location = self::get_location();

		global $wpdb;
		self::$ip_to_location_table = $wpdb->prefix . 'whtp_ip2location';
	} // __construct()

	/**
	 * Return an instance of this class.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self( $plugin_file );
		}

		return self::$instance;

	} // get_instance()

	/**
	 * Get the current visitor's country code
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function get_country_code( $ip = ' ' ) {

		if ( $ip == '' ) {
			$location = self::get_location();
		} else {
			$location = self::get_results_by_ip( $ip );
		}

		if ( isset( $location['country_code'] ) ) {
			return $location['country_code'];
		}

		return __( 'AA', 'whtp' );  // Dummy country code
	} // get_country_code()

	/**
	 * Get the name of the current visitor's country
	 *
	 * @return string - name of the current visitor's country
	 */
	public static function get_country_name( $ip = '' ) {
		if ( $ip == '' ) {
			$location = self::get_location();
		} else {
			$location = self::get_results_by_ip( $ip );
		}

		if ( isset( $location['country_name'] ) ) {
			return $location['country_name'];
		}

		return __( 'Unknown Country', 'whtp' );
	} // get_country_name()

	/**
	 * Get the location data of the current visitor
	 *
	 * @return array - the location data of the current visitor
	 */
	public static function get_results() {

		require_once WHTP_PLUGIN_DIR_PATH . 'vendor/autoload.php';

		$databaseFile = WHTP_PLUGIN_DIR_PATH . 'geodata/geodata/GeoLite2-City.mmdb';

		$reader = new Reader( $databaseFile );
		$record = $reader->get( self::get_ip_address() );
		$reader->close();

		return apply_filters(
			'whtp_locate_ip',
			array(
				'country_code'   => $record['country']['iso_code'],
				'country_name'   => $record['country']['names']['en'],
				'continent_code' => $record['continent']['iso_code'],
				'continent_name' => $record['continent']['names']['en'],
			),
			$record
		);
	}

	public static function country_code_to_ip( $country_code ) {
		global $wpdb, $ip_to_location_table;
	}

	public static function get_results_by_ip( $ip_address ) {
		if ( $ip_address == null ) {
			return array();
		}

		require_once WHTP_PLUGIN_DIR_PATH . 'vendor/autoload.php';

		$databaseFile = WHTP_PLUGIN_DIR_PATH . 'geodata/GeoLite2-City.mmdb';

		$reader = new Reader( $databaseFile );
		$record = $reader->get( $ip_address );
		$reader->close();

		return apply_filters(
			'whtp_locate_ip',
			array(
				'country_code'   => $record['country']['iso_code'],
				'country_name'   => $record['country']['names']['en'],
				'continent_code' => $record['continent']['iso_code'],
				'continent_name' => $record['continent']['names']['en'],
			),
			$record
		);
	}

	/**
	 * Get the current user's IP Address
	 *
	 * @return string - the IP address of the current visitor
	 */
	public static function get_ip_address() {

		if ( getenv( 'HTTP_CLIENT_IP' ) ) {
			return getenv( 'HTTP_CLIENT_IP' );
		} elseif ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
			return getenv( 'HTTP_X_FORWARDED_FOR' );
		} elseif ( getenv( 'HTTP_X_FORWARDED' ) ) {
			return getenv( 'HTTP_X_FORWARDED' );
		} elseif ( getenv( 'HTTP_FORWARDED_FOR' ) ) {
			return getenv( 'HTTP_FORWARDED_FOR' );
		} elseif ( getenv( 'HTTP_FORWARDED' ) ) {
			return getenv( 'HTTP_FORWARDED' );
		} elseif ( getenv( 'REMOTE_ADDR' ) ) {
			return getenv( 'REMOTE_ADDR' );
		}

		// We don't want to get here
		return '127.0.0.1';
	}

	/**
	 * Get the current location
	 *
	 * @return array - the current visitor's location data
	 */
	public static function get_location() {

		if ( self::$location == null ) {
			self::$location = self::get_results();
		}

		return self::$location;
	}

	/**
	 * Set the current user's location data
	 *
	 * @param  array $location
	 * @return array - the current user's location details
	 */
	public static function set_location( $location ) {
		self::$location = $location;

		return self::$location;
	}
}
