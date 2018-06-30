<?php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
?>
<div class="viewer wrap">
<?php
	/**
	* check if there is an action to reset counters
	*/
	if ( isset ( $_POST['reset_page'] ) || isset( $_GET['reset_page'] ) ):
		if ( $page == ""){
            $page = isset( $_POST['reset_page'] ) ? esc_attr( $_POST['reset_page'] ) : esc_attr( $_GET['reset_page'] );
        }
		if ( WHTP_Hits::reset_page_count() ) :
			if ( $page != "" ): ?>
                <div class="updated">
                    <p>
                        <?php echo sprintf( __('The count for the page "%s" has been reset successfully.', 'whtp'), esc_attr( $page ) ); ?>
                    </p>
                </div>'; 
            <?php else: ?>
				<div class="updated">
                    <p><?php _e( 'The count for all pages has been reset successfully.', 'whtp' ); ?></p>
                </div>
            <?php endif;		
		else: ?>
			<div class="update-nag">
                <p><?php _e( 'Failed to reset page counts', 'whtp' ); ?></p>
            </div><?php
        endif;
    endif;
    
	if ( isset( $_POST['delete_page'] ) || isset( $_GET['delete_page'] ) ) {
		if ( WHTP_Hits::delete_page() ){ ?>
			<div class="updated fade" id="message">
				<p>Page count(s) deleted. New entries will be made when users visit your pages again. If you no longer wish to count visits on certain pages, go to the page editor and remove the <code>[whohit]..[/whohit]<code> shortcode.
				</p>
			</div><?php
		}else{ ?>
			<div class="update-nag fade">
				<p><?php _e( 'Failed to remove page count(s).', 'whtp' ); ?></p>
			</div>
		<?php }
    }
    

	if ( isset( $_POST['discount_page'] ) || isset( $_POST['discount_page'] ) ) :
        if ( WHTP_Hits::discount_page() ) : ?>
            <div class="updated fade" id="message">
                <?php echo sprintf( 
                    __('The Page "%s" has been discounted by %d', 'whtp'), 
                    esc_attr( $page ), 
                    esc_attr( $discountby)
                ); ?>
            </div><?php
        else: ?>
                <div class="update-nag">
                    <p><?php _e( 'Failed to discount on the page', 'whtp' ); ?></p>
                </div><?php
        endif;
    endif;

	/**
	* Check if there is an action to be performed
	* to reset ip info
	*/
	if ( isset( $_POST['reset_ip'] ) || isset( $_POST['reset_ip'] ) ) :
		if ( WHTP_Hit_Info::reset_ip_info() ) : ?>
			<div class="updated">
				<p>
                    <?php echo sprintf( __( 'The count for ip address: "%s" has been reset successfully.', 'whtp' ), esc_attr( $_POST['reset_ip'] ) ); ?></p>
            </div><?php 
        else: ?>
			<div class="update-nag">
				<p><?php echo sprintf( __( 'Failed to reset count for IP: %s', 'whtp' ), esc_attr( $_POST['reset_ip'] ) ); ?></p>
            </div><?php
        endif; 
	endif;

if ( isset( $_POST['delete_ip'] ) ) :
	$ip_address = esc_attr($_POST['delete_this_ip']);	
	$delete_ip  = esc_attr ( $_POST['delete_ip'] );
	?>
	<div class="viewer wrap">
		<?php if ( WHTP_Hit_Info::delete_ip( $ip_address, $delete_ip ) ): ?>
			<div class="updated">
				<p><?php _e("IP addresse(s) removed from the database.", "whtp"); ?></p>
			</div>
		<?php else: ?>
			<div class="update">
				<p><?php _e("Failed to remove IP addresse(s) from database", "whtp"); ?></p>
			</div>
		<?php endif; ?>
	</div>
<?php endif;
	
if ( isset ( $_POST['deny_ip'] ) ): 
    if ( WHTP_Hit_Info::deny_ip() ) : ?>
        <div class="updated fade"  id="message">
            <p><?php _e( 'The IP Address will be ignored and will not be counted.', 'whtp' ); ?></p>
        </div>
    <?php else: ?>
        <div class="updated">
            <p><?php _e( 'Failed to add IP to ignore list', 'whtp'); ?></p>
        </div>
    <?php endif;
endif;


if (isset ($_POST['view_visitor'] ) ): ?>
	<h1><?php sprintf( __( "Visitor Data Goes Here for %s"), esc_attr( $view_visitor) ); ?></h1>";
<?php
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
            <h2 class="mdl-card__title-text">
                <?php _e( 'Pages visited and number of visits per page.', 'whtp' ); ?>
            </h2>
            <?php include( WHTP_PLUGIN_DIR_PATH . 'partials/view/all-page-hits.php'); ?>
            <p class="clear"><br /></p>
        </div>
    </div>
</div><!-- Wrap -->