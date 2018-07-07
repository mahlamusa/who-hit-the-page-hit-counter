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
	if ( isset ( $_GET['reset_page'] ) && wp_verify_nonce( $_GET['nonce'], 'delete_reset_deny' ) ):
        $page = isset( $_GET['reset_page'] );
        
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
    
    if ( isset( $_GET['delete_page'] ) && wp_verify_nonce( $_GET['nonce'], 'delete_reset_deny' ) ):
        if ( WHTP_Hits::delete_page( esc_attr( $_GET['delete_page'] ) ) ): ?>
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
    

	if ( isset( $_GET['discount_page'] ) && wp_verify_nonce( $_GET['nonce'], 'delete_reset_deny' ) ) :
        if ( WHTP_Hits::discount_page() ) : ?>
            <div class="update-message notice notice-success">
                <?php _e('The Page has been discounted by', 'whtp'); ?>
            </div><?php
        else: ?>
            <div class="update-message notice notice-warning">
                <p><?php _e( 'Failed to discount on the page', 'whtp' ); ?></p>
            </div><?php
        endif;
    endif;

    if ( isset ( $_POST['reset_all'] ) && wp_verify_nonce( $_POST['reset_all_nonce'], 'reset_all' ) ):
        if ( WHTP_Hits::delete_page( 'all' ) ) : ?>
			<div class="update-message notice notice-warning">
                <p><?php _e( 'The count for all pages has been reset successfully.', 'whtp' ); ?></p>
            </div><?php		
		else: ?>
			<div class="update-message notice notice-warning">
                <p><?php _e( 'Failed to reset page counts', 'whtp' ); ?></p>
            </div><?php
        endif;
    endif;

    if ( isset ( $_POST['delete_all'] ) && wp_verify_nonce( $_POST['delete_all_nonce'], 'delete_all' ) ):
        if ( WHTP_Hits::reset_page_count( 'all' ) ) : ?>
			<div class="update-message notice notice-warning">
                <p><?php _e( 'The count for all pages has been deleted successfully.', 'whtp' ); ?></p>
            </div><?php		
		else: ?>
			<div class="update-message notice notice-warning">
                <p><?php _e( 'Failed to delete page counts', 'whtp' ); ?></p>
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