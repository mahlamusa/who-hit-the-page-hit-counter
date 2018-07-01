<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
?>
<div class="wrap"><?php
    /**
    * Check if there is an action to be performed
    * to reset ip info
    */
    if ( isset( $_GET['reset_ip'] ) && wp_verify_nonce( $_GET['nonce'], 'nonce' ) ) :
        $ip_address = esc_attr( $_GET[ 'ip_address' ] );
        $which      = esc_attr( $_GET[ 'reset_ip' ] );

        if ( WHTP_Hit_Info::reset_ip_info( $ip_address, $which ) ) : ?>
            <div class="update-message notice notice-success">
                <p>
                    <?php printf( __( 'The count for ip address: "%s" has been reset successfully.', 'whtp' ), esc_attr( $_GET['ip_address'] ) ); ?>
                </p>
            </div><?php 
        else: ?>
            <div class="update-nag notice notice-warning">
                <p>
                    <?php printf( __( 'Failed to reset count for IP: %s', 'whtp' ), esc_attr( $_GET['reset_ip'] ) ); ?>
                </p>
            </div><?php
        endif; 
    endif;

    if ( isset( $_GET['delete_ip'] ) && wp_verify_nonce( $_GET['nonce'], 'nonce' ) ) :
        $ip_address = esc_attr( $_GET['delete_this_ip']);	
        $which      = esc_attr( $_GET['delete_ip'] );
        
        if ( WHTP_Hit_Info::delete_ip( $ip_address, $which ) ): ?>
                <div class="update-message notice notice-success">
                    <p><?php _e("IP addresse(s) removed from the database.", "whtp"); ?></p>
                </div>
            <?php 
        else: ?>
                <div class="update-message notice notice-warning">
                    <p><?php _e("Failed to remove IP addresse(s) from database", "whtp"); ?></p>
                </div>
            <?php 
        endif;
    endif;

    if ( isset ( $_GET['deny_ip'] ) && wp_verify_nonce( $_GET['nonce'], 'nonce' ) ): 
        if ( WHTP_Hit_Info::deny_ip( esc_attr( $_GET['deny_ip'] ) ) ) : ?>
            <div class="update-message notice notice-success">
                <p><?php _e( 'The IP Address will be ignored and will not be counted.', 'whtp' ); ?></p>
            </div>
        <?php else: ?>
            <div class="update-message notice notice-warning">
                <p><?php _e( 'Failed to add IP to ignore list', 'whtp'); ?></p>
            </div>
        <?php endif;
    endif; ?>
</div>

<div class="wrap">	
	<h2 class="mdl-card__title-text">
        <?php _e( 'Who Hit The Page Hit Counter - Visiting IP Addresses', 'whtp' ); ?>
    </h2>
    <p>
        <?php _e( 'View the raw hit counter information. This page lists all the IP addresses that have visited your pages.', 'whtp' ); ?>
    </p>


    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--9-col mdl-cell--9-col-tablet">
            <h2 class="mdl-card__title-text">
                <?php _e( 'Visitors\' IP addresses and Information', 'whtp' ); ?>    
            </h2>
            <?php include( WHTP_PLUGIN_DIR_PATH . 'partials/view/visiting-ip-addresses.php'); ?>
        </div>
    </div>
</div><!-- Wrap -->