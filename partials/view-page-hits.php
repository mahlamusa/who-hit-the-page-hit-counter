<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
?>
<div class="wrap">
<?php
	/**
	* check if there is an action to reset counters
	*/
	if ( isset ( $_REQUEST['reset_page'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'nonce' ) ):
        $page = isset( $_REQUEST['reset_page'] );
        
		if ( WHTP_Hits::reset_page_count( $page ) ) :
			if ( $page != "all" ): ?>
                <div class="update-message notice notice-success">
                    <p>
                        <?php printf( __('The count for the page "%s" has been reset successfully.', 'whtp'), esc_attr( $page ) ); ?>
                    </p>
                </div> 
            <?php else: ?>
				<div class="update-message notice notice-warning">
                    <p><?php _e( 'The count for all pages has been reset successfully.', 'whtp' ); ?></p>
                </div>
            <?php endif;		
		else: ?>
			<div class="update-message notice notice-warning">
                <p><?php _e( 'Failed to reset page counts', 'whtp' ); ?></p>
            </div><?php
        endif;
    endif;
    
	if ( isset( $_REQUEST['delete_page'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'nonce' ) ):
		if ( WHTP_Hits::delete_page( esc_attr( $_REQUEST['delete_page'] ) ) ): ?>
			<div class="update-message notice notice-success">
				<p>
                    <?php _e( 'Page count(s) deleted. New entries will be made when users visit your pages again. If you no longer wish to count visits on certain pages, go to the page editor and remove the <code>[whohit]..[/whohit]</code> shortcode.', 'whtp' ); ?>
				</p>
			</div><?php
		else: ?>
			<div class="update-message notice notice-warning">
				<p><?php _e( 'Failed to remove page count(s).', 'whtp' ); ?></p>
			</div><?php
        endif;
    endif;
    

	if ( isset( $_REQUEST['discount_page'] ) && wp_verify_nonce( $_REQUEST['nonce'], 'nonce' ) ) :
        if ( WHTP_Hits::discount_page() ) : ?>
            <div class="update-message notice notice-success">
                <?php echo sprintf( 
                    __('The Page "%s" has been discounted by %d', 'whtp'), 
                    esc_attr( $page ), 
                    esc_attr( $discountby)
                ); ?>
            </div><?php
        else: ?>
            <div class="update-message notice notice-warning">
                <p><?php _e( 'Failed to discount on the page', 'whtp' ); ?></p>
            </div><?php
        endif;
    endif;
?>
</div>
<div class="wrap">	
	<h2 class="mdl-card__title-text"><?php _e( 'Who Hit The Page Hit Counter', 'whtp' ); ?></h2>
    <p>
        <?php _e( 'Here you will see the raw page hit counter information. See all the visited pages along with the number of visits.', 'whtp' ); ?>
    </p>

    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--9-col mdl-cell--9-col-tablet">
            <?php include( WHTP_PLUGIN_DIR_PATH . 'partials/view/all-page-hits.php'); ?>
            <p class="clear"><br /></p>
        </div>
    </div>
</div><!-- Wrap -->