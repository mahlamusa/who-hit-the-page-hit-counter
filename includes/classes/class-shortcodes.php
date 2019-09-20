<?php
/**
 * Who Hit The Page Shortcodes
 *
 * @description adds all shortcodes
 * @package
 * @since       1.4.6
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_Shortcodes {

	public function __construct() {
		add_shortcode( 'whohit', array( $this, 'hit_counter_shortcode' ) );
		add_shortcode( 'whlinkback', array( $this, 'link_back' ) );
	}

	public static function hit_counter_shortcode( $atts = null, $content = null ) {
		extract( shortcode_atts( array( 'id' => '' ), $atts ) );
		if ( $content != '' ) {
			$page = $content;
		}
		WHTP_Hits::count_page( $page );
	}

	public static function link_back() {
		return sprintf(
			__( '<a href="http://lindeni.co.za" rel="bookmark" title="%1$s" target="_blank">%2$s</a>' ),
			__( 'WordPress plugins and web design resources', 'whtp' ),
			__( 'WordPress plugins by Mahlamusa Mahlalela', 'whtp' )
		);
	}
}

add_action(
	'init',
	function () {
		$whtpshortcodes = new WHTP_Shortcodes();
	}
);
