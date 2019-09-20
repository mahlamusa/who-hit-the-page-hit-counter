<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_Browser {

	private static $user_agents_table;

	public function __construct() {
		global $wpdb;
		self::$user_agents_table = $wpdb->prefix . 'whtp_user_agents';
	}

	/*
	*   Get agent id
	*/
	public static function get_agent_id( $browser ) {
		global $wpdb, $user_agents_table;

		$ua_id = $wpdb->get_var(
			"SELECT agent_id 
            FROM `$user_agents_table` 
            WHERE agent_name = '$browser' LIMIT 1"
		);

		if ( $ua_id ) {
			return $ua_id;
		} else {
			return 'Unknown Browser';
		}
	}

	public static function browser_exists( $browser ) {
		global $wpdb, $user_agents_table;

		$browser = $wpdb->get_var(
			"SELECT agent_name 
            FROM `$user_agents_table` 
            WHERE agent_name='$browser' LIMIT 1"
		);

		if ( $browser ) {
			return true;
		} else {
			return false;
		}
	}

	public static function add_browser( $browser, $details = '' ) {
		global $wpdb, $user_agents_table;

		$wpdb->insert(
			$user_agents_table,
			array(
				'agent_name'    => $browser,
				'agent_details' => $details,
			),
			array( '%s', '%s' )
		);
	}

	public static function get_browsers() {
		global $wpdb, $user_agents_table;

		return $wpdb->get_results( "SELECT agent_name FROM `$user_agents_table`" );
	}

	public static function get_browser_name( $agent_id ) {
		global $wpdb, $user_agents_table;
		return $wpdb->get_var(
			"SELECT agent_name 
            FROM $user_agents_table 
            WHERE agent_id='$agent_id' LIMIT 1"
		);
	}

	public static function browser_info() {

		$browser_info = array();
		$browser      = new BrowserDetection();

		if ( $browser->getBrowser() == BrowserDetection::BROWSER_AMAYA ) {
			$browser_info['name']    = 'Amaya';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_ANDROID ) {
			$browser_info['name']    = 'Android';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_BINGBOT ) {
			$browser_info['name']    = 'Bingbot';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_BLACKBERRY ) {
			$browser_info['name']    = 'BlackBerry';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_CHROME ) {
			$browser_info['name']    = 'Chrome';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_FIREBIRD ) {
			$browser_info['name']    = 'Firebird';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_FIREFOX ) {
			$browser_info['name']    = 'Firefox';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_GALEON ) {
			$browser_info['name']    = 'Galeon';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_GOOGLEBOT ) {
			$browser_info['name']    = 'Googlebot';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_ICAB ) {
			$browser_info['name']    = 'iCab';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_ICECAT ) {
			$browser_info['name']    = 'GNU IceCat';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_ICEWEASEL ) {
			$browser_info['name']    = 'GNU IceWeasel';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_IE ) {
			$browser_info['name']    = 'Internet Explorer';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_IE_MOBILE ) {
			$browser_info['name']    = 'Internet Explorer Mobile';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_KONQUEROR ) {
			$browser_info['name']    = 'Konqueror';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_LYNX ) {
			$browser_info['name'] = 'Lynx';
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_MOZILLA ) {
			$browser_info['name']    = 'Mozilla';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_MSNBOT ) {
			$browser_info['name']    = 'MSNBot';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_MSNTV ) {
			$browser_info['name']    = 'MSN TV';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_NETPOSITIVE ) {
			$browser_info['name']    = 'NetPositive';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_NETSCAPE ) {
			$browser_info['name']    = 'Netscape';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_NOKIA ) {
			$browser_info['name']    = 'Nokia Browser';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_OMNIWEB ) {
			$browser_info['name']    = 'OmniWeb';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_OPERA ) {
			$browser_info['name']    = 'Opera';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_OPERA_MINI ) {
			$browser_info['name']    = 'Opera Mini';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_OPERA_MOBILE ) {
			$browser_info['name']    = 'Opera Mobile';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_PHOENIX ) {
			$browser_info['name']    = 'Phoenix';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_SAFARI ) {
			$browser_info['name']    = 'Safari';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_SLURP ) {
			$browser_info['name'] = 'Yahoo! Slurp';
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_TABLET_OS ) {
			$browser_info['name']    = 'BlackBerry Tablet OS';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_W3CVALIDATOR ) {
			$browser_info['name']    = 'W3C Validator';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_YAHOO_MM ) {
			$browser_info['name']    = 'Yahoo! Multimedia';
			$broswer_info['version'] = $browser->getVersion();
		} elseif ( $browser->getBrowser() == BrowserDetection::BROWSER_UNKNOWN ) {
			$browser_info['name']    = 'Unknown';
			$broswer_info['version'] = 'Unknown';
		}

		return $browser_info;
	}
}
