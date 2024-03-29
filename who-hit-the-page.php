<?php
/**
 * @package Who_Hit_The_Page
 * @author Lindeni Mahlalela
 *
 * Plugin Name: Who Hit The Page - Hit Counter
 * Plugin URI: http://whohit.co.za/who-hit-the-page-hit-counter
 * Description: Lets you know who visted your pages by adding an invisible page hit counter on your website, so you know how many times a page has been visited in total and how many times each user identified by IP address has visited each page. You will also know the IP addresses of your visitors and relate the IP addresses to the country of the visitor and all browsers used by that IP/user.
 * Version: 1.4.10
 * Author: mahlamusa
 * Author URI: http://lindeni.co.za
 * License: GPL
 * Text Domain: whtp
 * Domain Path: /languages
 *
 * Copyright © 2012 - 2019 Lindeni Mahlalela. All rights reserved.
 * <himself@lindeni.co.za>
 * <https://lindeni.co.za>
 *
 * Permission to use, copy, modify, and distribute this software for any
 * purpose with or without fee is hereby granted, provided that the above
 * copyright notice and this permission notice appear in all copies.
 *
 * THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'WHTP_VERSION', '1.4.6' );
define( 'WHTP_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );

if ( ! defined( 'WP_PLUGIN_DIR' ) ) {
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
}

/**
 * Load text domain.
 *
 * @return void
 * @version 1.4.11
 * @since   1.4.11
 */
function whtp_text_domain() {
	load_plugin_textdomain( 'whtp', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'whtp_text_domain' );

require_once 'includes/config.php';

require_once 'includes/classes/class-whtp-database.php';
require_once 'includes/classes/class-browser-detection.php';
require_once 'includes/classes/class-browser.php';
require_once 'includes/classes/class-hit-info.php';
require_once 'includes/classes/class-hits.php';
require_once 'includes/classes/class-ip-hits.php';
require_once 'includes/classes/class-ip-to-location.php';
require_once 'includes/classes/class-shortcodes.php';
require_once 'includes/classes/class-visiting-countries.php';
require_once 'includes/functions.php';

register_activation_hook( __FILE__, 'whtp_installer' );
register_deactivation_hook( __FILE__, 'whtp_remove' );

/**
 * $plugin = WHTP_Functions::plugin_info();
 * define( "WHTP_VERSION", $plugin['Version'] );
 */

/**
 * Installer
 *
 * @return void
 * @version 1.4.11
 * @since   1.4.11
 */
function whtp_installer() {
	require_once 'includes/config.php';
	require_once 'includes/installer.php';
	$installer = new WHTP_Installer();
}

/**
 * Deactivate
 *
 * @return void
 * @version 1.4.11
 * @since   1.4.11
 */
function whtp_remove() {
	require_once 'includes/config.php';
	require_once 'includes/uninstaller.php';
	$deactivator = new WHTP_Deactivator();
}

/**
 * Admin class
 *
 * @version 1.4.11
 * @since   1.4.11
 */
class Who_Hit_The_Page_Admin {

	/**
	 * Construct
	 *
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Hooks
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function hooks() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_action( 'admin_init', array( $this, 'suggest_privacy_content' ), 20 );
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'add_action_links' ) );

		if ( self::is_whtp_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}
	}

	/**
	 * Admin menu
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function admin_menu() {
		add_menu_page(
			__( 'Who Hit The Page', 'whtp' ),
			__( 'Who Hit The Page', 'whtp' ),
			'administrator',
			'whtp-admin-menu',
			array( $this, 'whtp_object_page_callback' ),
			WHTP_PLUGIN_URL . 'assets/images/whtp-icon.png'
		);
		do_action( 'whtp_admin_menu_after_dashboard' );
		add_submenu_page(
			'whtp-admin-menu',
			__( 'View Page Hits', 'whtp' ),
			__( 'View Page Hits', 'whtp' ),
			'administrator',
			'whtp-view-page-hits',
			array( $this, 'whtp_view_page_hits' )
		);

		add_submenu_page(
			'whtp-admin-menu',
			__( 'View IP Hits', 'whtp' ),
			__( 'View IP Hits', 'whtp' ),
			'administrator',
			'whtp-view-ip-hits',
			array( $this, 'whtp_view_ip_hits' )
		);
		add_submenu_page(
			'whtp-admin-menu',
			__( 'Visitor Stats', 'whtp' ),
			__( 'Visitor Stats', 'whtp' ),
			'administrator',
			'whtp-visitor-stats',
			array( $this, 'whtp_visitors_stats_callback' )
		);
		add_submenu_page(
			'whtp-admin-menu',
			__( 'Denied IPs', 'whtp' ),
			__( 'Denied IPs', 'whtp' ),
			'administrator',
			'whtp-denied-ips',
			array( $this, 'whtp_denied_submenu_callback' )
		);
		/**
		 * add_submenu_page(
			'whtp-admin-menu',
			__('Export / Import', 'whtp'),
			__('Export / Import', 'whtp'),
			'administrator',
			'whtp-import-export',
			array( $this, 'whtp_export_import_submenu_callback' )
		);
		*/
		add_submenu_page(
			'whtp-admin-menu',
			__( 'Settings', 'whtp' ),
			__( 'Settings', 'whtp' ),
			'administrator',
			'whtp-settings',
			array( $this, 'whtp_settings_submenu_callback' )
		);
		do_action( 'whtp_admin_menu_after_settings' );

		add_submenu_page(
			'whtp-admin-menu',
			__( 'Help', 'whtp' ),
			__( 'Help', 'whtp' ),
			'administrator',
			'whtp-help',
			array( $this, 'whtp_help_submenu_callback' )
		);
		do_action( 'whtp_admin_menu_after_help' );

		add_submenu_page(
			'whtp-admin-menu',
			__( 'Force Update', 'whtp' ),
			'',
			'administrator',
			'whtp-force-update',
			array( $this, 'whtp_force_update' )
		);

		do_action( 'whtp_admin_menu_after' );
	}

	/**
	 * Submenu callback functions
	 */
	public function whtp_object_page_callback() {
		require_once WHTP_PLUGIN_DIR_PATH . 'partials/view/stats-summary.php';
	}

	/**
	 * Sow denied IPs
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function whtp_denied_submenu_callback() {
		require_once WHTP_PLUGIN_DIR_PATH . 'partials/view/denied-ips.php';
	}

	/**
	 * Show visitor stats
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function whtp_visitors_stats_callback() {
		require_once WHTP_PLUGIN_DIR_PATH . 'partials/view/visitor-info.php';
	}

	/**
	 * View IPs
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function whtp_view_ip_hits() {
		require_once WHTP_PLUGIN_DIR_PATH . 'partials/view-ip-hits.php';
	}

	/**
	 * View page hits.
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function whtp_view_page_hits() {
		require_once WHTP_PLUGIN_DIR_PATH . 'partials/view-page-hits.php';
	}

	/**
	 * Import exports page
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function whtp_export_import_submenu_callback() {
		require_once WHTP_PLUGIN_DIR_PATH . 'partials/export-import.php';
	}

	/**
	 * Settings page
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function whtp_settings_submenu_callback() {
		require_once WHTP_PLUGIN_DIR_PATH . 'partials/settings.php';
	}

	/**
	 * View help
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function whtp_help_submenu_callback() {
		require_once WHTP_PLUGIN_DIR_PATH . 'partials/help.php';
	}

	/**
	 * Force update
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function whtp_force_update() {
		require_once WHTP_PLUGIN_DIR_PATH . 'partials/update/force-update.php';
	}

	/**
	 * Is page admin
	 *
	 * @param string $page The page to check.
	 * @return boolean
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public static function is_whtp_admin( $page = '' ) {
		if ( '' === $page ) {
			$page = ! empty( $_GET['page'] ) ? esc_attr( $_GET['page'] ) : '';
		}

		if ( empty( $page ) ) {
			return false;
		}

		$whtp_pages = array( 'whtp-admin-menu', 'whtp-view-page-hits', 'whtp-visitor-stats', 'whtp-view-ip-hits', 'whtp-denied-ips', 'whtp-denied-ips', 'whtp-import-export', 'whtp-settings', 'whtp-help', 'whtp-widget-settings' );

		return in_array( $page, $whtp_pages, true );
	}

	/**
	 * Plugin action links
	 *
	 * @param array $links List of plugin action links.
	 * @return array
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function add_action_links( $links ) {
		$links[] = '<a href="' . admin_url( 'admin.php?page=whtp-settings' ) . '">' . __( 'Settings', 'whtp' ) . '</a>';
		$links[] = '<a href="' . admin_url( 'admin.php?page=whtp-help' ) . '">' . __( 'Help', 'whtp' ) . '</a>';
		$links[] = '<a href="http://whohit.co.za/who-hit-the-page-hit-counter" target="_blank">' . __( 'Documentation', 'whtp' ) . '</a>';
		return $links;
	}

	/**
	 * Enqueue scripts
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function enqueue_styles() {
		wp_register_style(
			'mdl-admin-css',
			'https://code.getmdl.io/1.3.0/material.indigo-pink.min.css',
			array(),
			'all'
		);
		wp_register_style(
			'mdl-admin-icons',
			'https://fonts.googleapis.com/icon?family=Material+Icons',
			array(),
			'all'
		);
		wp_register_style(
			'select2',
			'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css',
			array(),
			'all'
		);
		wp_register_style(
			'whtp-admin-css',
			WHTP_PLUGIN_URL . 'assets/css/whtp-admin.min.css',
			array(),
			'all'
		);

		wp_enqueue_style( 'mdl-admin-css' );
		wp_enqueue_style( 'select2' );
		wp_enqueue_style( 'mdl-admin-icons' );
		wp_enqueue_style( 'whtp-admin-css' );
	}

	/**
	 * Enqueue scripts
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public function enqueue_scripts() {
		wp_register_script(
			'mdl-js',
			'https://code.getmdl.io/1.3.0/material.min.js',
			null,
			true
		);
		wp_register_script(
			'whtp-admin-js',
			WHTP_PLUGIN_URL . 'assets/js/whtp-admin.min.js',
			array( 'jquery' ),
			true
		);
		wp_register_script(
			'select2',
			'//cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js',
			array( 'jquery' ),
			true
		);

		wp_enqueue_script( 'mdl-js' );
		wp_enqueue_script( 'select2' );
		wp_enqueue_script( 'whtp-admin-js' );
	}

	/**
	 * Admin notices
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public static function admin_notices() {
		if ( ! WHTP_Hits::count_exists() && ! WHTP_Visiting_Countries::count_exists() ) :
			return;
		else :
		?>
		<div class="notice notice-update update-nag is-dismissible">
			<p>
			<?php
				printf(
					__( 'We notice that you have updated the plugin! We need to update the database to make sure the plugin works as it should. <a href="%s" class="button">Click here to update database</a>', 'whtp' ),
					admin_url( 'admin.php?page=whtp-settings&action=update_whtp_database&whtp_nonce=' . wp_create_nonce( 'whtp_update_db' ) )
				);
				?>
			</p>
		</div>
		<?php
		endif;
	}

	/**
	 * Get default privacy content
	 *
	 * @return string
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public static function get_default_privacy_content() {
		return '<h2>' . __( 'The IP address, user agent/browser name will be recorded for internal statistical purposes.', 'whtp' ) . '</h2>' .
		'<p>' . __( 'Who Hit The Page Hit Counter collect the visitor\s IP address and the browser name or user agent used to visit the page, it also records the time and the pages visited by the speciic IP address. This data is collected for statistical purposes only and is not in any way linked to a user\'s account on this website', 'whtp' ) . '</p>';
	}

	/**
	 * Suggest privacy content
	 *
	 * @return void
	 * @version 1.4.11
	 * @since   1.4.11
	 */
	public static function suggest_privacy_content() {
		$content = self::get_default_privacy_content();
		wp_add_privacy_policy_content( __( 'Who Hit The Page Hit Counter' ), $content );
	}
}

/**
 * Initialize plugin once plugins are loaded.
 */
add_action(
	'plugins_loaded',
	function() {
		global $whtpa;
		$whtpa = new Who_Hit_The_Page_Admin();
	}
);
