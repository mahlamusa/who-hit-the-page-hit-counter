<?php
define('WHTP_PLUGIN_URL', WP_CONTENT_URL . '/plugins/who-hit-the-page-hit-counter/');
define('WHTP_IMAGES_URL', WHTP_PLUGIN_URL . 'images/');
define('WHTP_FLAGS_URL', WHTP_IMAGES_URL . 'flags/');
define('WHTP_BROSWERS_URL', WHTP_IMAGES_URL . 'browsers/');
define('WHTP_GEODATA_URL', WHTP_PLUGIN_URL . 'geodata/');

if ( ! defined( 'WP_PLUGIN_DIR' ) ){
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
}
?>