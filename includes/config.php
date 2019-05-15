<?php

global $wpdb;
global $hits_table,
	$hitinfo_table,
	$user_agents_table,
	$ip_hits_table,
	$visiting_countries_table,
	$ip_to_location_table;

$hits_table               = $wpdb->prefix . 'whtp_hits';
$hitinfo_table            = $wpdb->prefix . 'whtp_hitinfo';
$user_agents_table        = $wpdb->prefix . 'whtp_user_agents';
$ip_hits_table            = $wpdb->prefix . 'whtp_ip_hits';
$visiting_countries_table = $wpdb->prefix . 'whtp_visiting_countries';
$ip_to_location_table     = $wpdb->prefix . 'whtp_ip2location';

define( 'WHTP_HITS_TABLE', $wpdb->prefix . 'whtp_hits' );
define( 'WHTP_HITINFO_TABLE', $wpdb->prefix . 'whtp_hitinfo' );
define( 'WHTP_USER_AGENTS_TABLE', $wpdb->prefix . 'whtp_user_agents' );
define( 'WHTP_IP_HITS_TABLE', $wpdb->prefix . 'whtp_ip_hits' );
define( 'WHTP_VISITING_COUNTRIES_TABLE', $wpdb->prefix . 'whtp_visiting_countries' );
define( 'WHTP_IP2_LOCATION_TABLE', $wpdb->prefix . 'whtp_ip2location' );

define( 'WHTP_PLUGIN_URL', plugins_url( '/who-hit-the-page-hit-counter/' ) );
// define( 'WHTP_PLUGIN_URL',        WP_CONTENT_URL . '/plugins/who-hit-the-page-hit-counter/');
define( 'WHTP_IMAGES_URL', WHTP_PLUGIN_URL . 'assets/images/' );
define( 'WHTP_FLAGS_URL', WHTP_IMAGES_URL . 'flags/' );
define( 'WHTP_BROSWERS_URL', WHTP_IMAGES_URL . 'browsers/' );
define( 'WHTP_GEODATA_URL', WHTP_PLUGIN_URL . 'geodata/' );

define( 'WHTP_BACKUP_DIR', WP_CONTENT_DIR . '/uploads/whtp_backups' );
