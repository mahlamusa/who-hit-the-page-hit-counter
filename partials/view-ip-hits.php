<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap">
<?php
	/**
	 * Check if there is an action to be performed
	 * to reset ip info
	 */
if ( isset( $_GET['reset_ip'] ) && isset( $_GET['ip_address'] ) && wp_verify_nonce( $_GET['nonce'], 'delete_reset_deny' ) ) :
	$ip_address = esc_attr( $_GET['ip_address'] );

	if ( WHTP_Hit_Info::reset_ip_info( $ip_address ) ) :
	?>
	  <div class="notice notice-success">
				<p>
		<?php printf( __( 'The count for ip address: "%s" has been reset successfully.', 'whtp' ), esc_attr( $_GET['ip_address'] ) ); ?>
				</p>
	  </div>
		<?php
		else :
	?>
			<div class="update-nag notice notice-warning">
				<p>
		<?php printf( __( 'Failed to reset count for IP: %s', 'whtp' ), esc_attr( $_GET['reset_ip'] ) ); ?>
				</p>
			</div>
	<?php
		endif;
endif;

if ( isset( $_GET['delete_ip'] ) && isset( $_GET['ip_address'] ) && wp_verify_nonce( $_GET['nonce'], 'delete_reset_deny' ) ) :
	$ip_address = esc_attr( $_GET['ip_address'] );

	if ( WHTP_Hit_Info::delete_ip( $ip_address ) ) :
	?>
				<div class="notice notice-success">
					<p><?php esc_attr_e( 'IP addresse(s) removed from the database.', 'whtp' ); ?></p>
				</div>
		<?php
		else :
	?>
				<div class="notice notice-warning">
					<p><?php esc_attr_e( 'Failed to remove IP addresse(s) from database', 'whtp' ); ?></p>
				</div>
	<?php
		endif;
endif;

if ( isset( $_GET['deny_ip'] ) && isset( $_GET['ip_address'] ) && wp_verify_nonce( $_GET['nonce'], 'delete_reset_deny' ) ) :

	$ip_address = esc_attr( $_GET['ip_address'] );

	if ( WHTP_Hit_Info::deny_ip( $ip_address ) ) :
	?>
	  <div class="notice notice-success">
				<p><?php esc_attr_e( 'The IP Address will be ignored and will not be counted.', 'whtp' ); ?></p>
	  </div>
		<?php else : ?>
			<div class="notice notice-warning">
				<p><?php esc_attr_e( 'Failed to add IP to ignore list', 'whtp' ); ?></p>
			</div>
	<?php
		endif;
endif;

if ( isset( $_POST['delete_all_ips'] ) && wp_verify_nonce( $_POST['delete_all_ips_nonce'], 'delete_all_ips' ) ) :
	if ( WHTP_Hit_Info::delete_ip( '', 'all' ) ) :
	?>
				<div class="notice notice-success">
					<p><?php esc_attr_e( 'IP addresse(s) removed from the database.', 'whtp' ); ?></p>
				</div>
		<?php
		else :
	?>
				<div class="notice notice-warning">
					<p><?php esc_attr_e( 'Failed to remove IP addresse(s) from database', 'whtp' ); ?></p>
				</div>
	<?php
		endif;
endif;

if ( isset( $_POST['reset_all_ips'] ) && wp_verify_nonce( $_POST['reset_all_ips_nonce'], 'reset_all_ips' ) ) :
	$ip_address = esc_attr( $_GET['ip_address'] );

	if ( WHTP_Hit_Info::reset_ip_info( $ip_address, 'all' ) ) :
	?>
	  <div class="notice notice-success">
				<p>
		<?php esc_attr_e( 'The count for all IP addresses has been reset successfully.', 'whtp' ); ?>
				</p>
	  </div>
		<?php
		else :
	?>
			<div class="update-nag notice notice-warning">
				<p>
		<?php esc_attr_e( 'Failed to reset count for all IP addresses', 'whtp' ); ?>
				</p>
			</div>
	<?php
		endif;
endif;
	?>
</div>

<div class="wrap">    
	<h2 class="mdl-card__title-text">
	<?php esc_attr_e( 'Who Hit The Page Hit Counter - Visiting IP Addresses', 'whtp' ); ?>
	</h2>
	<p>
	<?php esc_attr_e( 'View the raw hit counter information. This page lists all the IP addresses that have visited your pages.', 'whtp' ); ?>
	</p>


	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--9-col mdl-cell--9-col-tablet">
	<?php require WHTP_PLUGIN_DIR_PATH . 'partials/view/visiting-ip-addresses.php'; ?>
		</div>
	</div>
</div><!-- Wrap -->
