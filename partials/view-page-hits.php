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
if ( isset( $_GET['reset_page'] ) && isset( $_GET['page_id'] ) && wp_verify_nonce( $_GET['nonce'], 'delete_reset_deny' ) ) :
	$page_id = esc_attr( $_GET['page_id'] );

	if ( WHTP_Hits::reset_page_count( $page_id ) ) :
	?>
	  <div class="notice notice-success">
				<p>
		<?php esc_attr_e( 'The count for the page has been reset successfully.', 'whtp' ); ?>
				</p>
	  </div>
		<?php
		else :
	?>
			<div class="notice notice-warning">
				<p><?php esc_attr_e( 'Failed to reset page counts', 'whtp' ); ?></p>
			</div>
	<?php
		endif;
endif;

if ( isset( $_GET['delete_page'] ) && isset( $_GET['page_id'] ) && wp_verify_nonce( $_GET['nonce'], 'delete_reset_deny' ) ) :

	$page_id = esc_attr( $_GET['page_id'] );

	if ( WHTP_Hits::delete_page( $page_id ) ) :
	?>
	  <div class="notice notice-success">
				<p>
		<?php esc_attr_e( 'Page count deleted. New entries will be made when users visit your pages again. If you no longer wish to count visits on certain pages, go to the page editor and remove the <code>[whohit]..[/whohit]</code> shortcode.', 'whtp' ); ?>
				</p>
	  </div>
		<?php
		else :
	?>
			<div class="notice notice-warning">
				<p><?php esc_attr_e( 'Failed to remove page count(s).', 'whtp' ); ?></p>
			</div>
	<?php
		endif;
endif;


if ( isset( $_POST['discount_page'] ) && wp_verify_nonce( $_POST['nonce'], 'delete_reset_deny' ) ) :
	if ( WHTP_Hits::discount_page( esc_attr( $_GET['discount_page'] ), esc_attr( $_POST['discountby'] ) ) ) :
	?>
	  <div class="notice notice-success">
				<?php esc_attr_e( 'The Page has been discounted by', 'whtp' ); ?>
	  </div>
		<?php
		else :
	?>
			<div class="notice notice-warning">
				<p><?php esc_attr_e( 'Failed to discount on the page', 'whtp' ); ?></p>
			</div>
	<?php
		endif;
endif;

if ( isset( $_POST['reset_all_pages'] ) && wp_verify_nonce( $_POST['reset_all_pages_nonce'], 'reset_all_pages' ) ) :
	if ( WHTP_Hits::delete_page( 'all' ) ) :
	?>
	  <div class="notice notice-success">
				<p><?php esc_attr_e( 'The count for all pages has been reset successfully.', 'whtp' ); ?></p>
	  </div>
		<?php
		else :
	?>
			<div class="notice notice-warning">
				<p><?php esc_attr_e( 'Failed to reset page counts', 'whtp' ); ?></p>
			</div>
	<?php
		endif;
endif;

if ( isset( $_POST['delete_all_pages'] ) && wp_verify_nonce( $_POST['delete_all_pages_nonce'], 'delete_all_pages' ) ) :
	if ( WHTP_Hits::reset_page_count( 'all' ) ) :
	?>
	  <div class="notice notice-warning">
				<p><?php esc_attr_e( 'The count for all pages has been deleted successfully.', 'whtp' ); ?></p>
	  </div>
		<?php
		else :
	?>
			<div class="notice notice-warning">
				<p><?php esc_attr_e( 'Failed to delete page counts', 'whtp' ); ?></p>
			</div>
	<?php
		endif;
endif;
?>
</div>
<div class="wrap">    
	<h2 class="mdl-card__title-text"><?php esc_attr_e( 'Who Hit The Page Hit Counter', 'whtp' ); ?></h2>
	<p>
	<?php esc_attr_e( 'Here you will see the raw page hit counter information. See all the visited pages along with the number of visits.', 'whtp' ); ?>
	</p>

	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--9-col mdl-cell--9-col-tablet">
	<?php require WHTP_PLUGIN_DIR_PATH . 'partials/view/all-page-hits.php'; ?>
			<p class="clear"><br /></p>
		</div>
	</div>
</div><!-- Wrap -->
