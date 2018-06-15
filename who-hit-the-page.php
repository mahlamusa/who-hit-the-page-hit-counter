<?php
/*
Plugin Name: Who Hit The Page - Hit Counter
Plugin URI: http://whohit.co.za/who-hit-the-page-hit-counter
Description: Lets you know who visted your pages by adding an invisible page hit counter on your website, so you know how many times a page has been visited in total and how many times each user identified by IP address has visited each page. You will also know the IP addresses of your visitors and relate the IP addresses to the country of the visitor and all browsers used by that IP/user.
Version: 1.4.5
Author: mahlamusa
Author URI: http://lindeni.co.za
Plugin URI: http://whohit.co.za
License: GPL
*/
/*
 * Copyright © 2012 - 2018 Lindeni Mahlalela. All rights reserved.
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



if ( ! defined( 'WP_PLUGIN_DIR' ) ){
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
}

function whtp_text_domain(){
	load_plugin_textdomain( 'whtp', false, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'whtp_text_domain' );

include( 'includes/config.php' );

include('includes/classes/class-whtp-database.php');
include('includes/classes/class-browser-detection.php');
include('includes/classes/class-browser.php');
include('includes/classes/class-hit-info.php');
include('includes/classes/class-hits.php');
include('includes/classes/class-ip-hits.php');
include('includes/classes/class-ip-to-location.php');
include('includes/classes/class-shortcodes.php');
include('includes/classes/class-visiting-countries.php');
include('includes/functions.php');

register_activation_hook(__FILE__,'whtp_installer');
register_deactivation_hook(__FILE__,'whtp_remove');

$plugin = WHTP_Functions::plugin_info();
define( "WHTP_VERSION", $plugin['Version'] );

function whtp_installer(){
	require_once('includes/installer.php');
	$installer = new WHTP_Installer();
}

function whtp_remove(){
	require_once('includes/uninstaller.php');
	$deactivator = new WHTP_Deactivator();
}

class Who_Hit_The_Page_Admin{
	public function __construct(){
		
		add_action( 'admin_menu', array( $this, 'admin_menu') );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	public function admin_menu(){		
		add_object_page(
			__('Who Hit The Page', 'whtp'), 
			__('Who Hit The Page', 'whtp'), 
			'administrator', 
			'whtp-admin-menu',
			array( $this, 'whtp_object_page_callback' )
		);
		
		add_submenu_page(
			'whtp-admin-menu',
			__('View All Details', 'whtp'),
			__('View All Details', 'whtp'),
			'administrator',
			'whtp-view-all',
			array( $this, 'whtp_view_all_callback' )
		);
		add_submenu_page(
			'whtp-admin-menu',
			__('Visitor Stats', 'whtp'),
			__('Visitor Stats', 'whtp'),
			'administrator',
			'whtp-visitor-stats',
			array( $this, 'whtp_visitors_stats_callback' )
		);
		add_submenu_page(
			'whtp-admin-menu',
			__('Denied IPs', 'whtp'),
			__('Denied IPs', 'whtp'),
			'administrator',
			'whtp-denied-ips',
			array( $this, 'whtp_denied_submenu_callback' )
		);
		add_submenu_page(
			'whtp-admin-menu',
			__('Export / Import', 'whtp'),
			__('Export / Import', 'whtp'),
			'administrator',
			'whtp-import-export',
			array( $this, 'whtp_export_import_submenu_callback' )
		);
		add_submenu_page(
			'whtp-admin-menu',
			__('Settings', 'whtp' ),
			__('Settings', 'whtp' ),
			'administrator',
			'whtp-settings',
			array( $this, 'whtp_settings_submenu_callback' )
		);
		add_submenu_page(
			'whtp-admin-menu',
			__('Help', 'whtp' ),
			__('Help', 'whtp' ),
			'administrator',
			'whtp-help',
			array( $this, 'whtp_help_submenu_callback' )
		);
	}

	/*
	* Submenu callback functions
	*/
	public function whtp_object_page_callback(){
		include( WHTP_PLUGIN_DIR_PATH . 'partials/view/stats-summary.php');
	}
	public function whtp_denied_submenu_callback(){
		include( WHTP_PLUGIN_DIR_PATH . 'partials/view/denied-ips.php'); //admin page
	}
	
	public function whtp_visitors_stats_callback(){
		include( WHTP_PLUGIN_DIR_PATH . 'partials/view/visitor-info.php'); //admin page
	}
	public function whtp_view_all_callback(){
		include( WHTP_PLUGIN_DIR_PATH . 'partials/view-all.php');//admin page
	}
	public function whtp_export_import_submenu_callback(){
		include( WHTP_PLUGIN_DIR_PATH . 'partials/export-import.php');//admin page
	}
	public function whtp_settings_submenu_callback(){
		include( WHTP_PLUGIN_DIR_PATH . 'partials/settings.php');//admin page
	}
	public function whtp_help_submenu_callback(){
		include( WHTP_PLUGIN_DIR_PATH . 'partials/help.php');//admin page
	}

	public function enqueue_styles(){
		wp_register_style( 
            'mdl-admin-css', 
            'https://code.getmdl.io/1.3.0/material.indigo-pink.min.css'
        );
        wp_register_style( 
            'mdl-admin-icons', 
            'https://fonts.googleapis.com/icon?family=Material+Icons'
		);
		wp_register_style( 
			'whtp-admin-css', 
			WHTP_PLUGIN_URL . 'assets/css/whtp-admin.min.css'
		);

		wp_enqueue_style( 'mdl-admin-css' );
        wp_enqueue_style( 'mdl-admin-icons' );
        wp_enqueue_style( 'whtp-admin-css' );
	}

	public function enqueue_scripts() {
		wp_register_script( 
            'mdl-admin-js', 
            'https://code.getmdl.io/1.3.0/material.min.js',
            null, null, true
		);
		wp_register_script( 
			'whtp-main-js', 
			WP_HOST_PANEL_PLUGIN_URL . 'assets/js/whtp-admin.min.js', 
			array( 'jquery' ), 
			null
		);

		wp_enqueue_script( 'mdl-admin-js' );
		wp_enqueue_script( 'whtp-admin-js' );
	}
}
add_action("plugins_loaded", function(){
	global $whtp;
	$whtpa = new Who_Hit_The_Page_Admin();
});
?>