<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_POST['update-backup-options'] ) ) {
	$update_export_action = update_option( 'whtp_data_export_action', esc_attr( $_POST['backup-action'] ) );
}
$export_option = get_option( 'whtp_data_export_action' );

if ( isset( $_POST['update-uninstall-option'] ) ) {
	$update_uninstall_action = update_option( 'whtp_data_action', esc_attr( $_POST['uninstall-action'] ) );
}
$option = get_option( 'whtp_data_action' );

if ( isset( $_POST['update-uninstall-option'] ) || isset( $_POST['update-backup-options'] ) ) :
	if ( isset( $update_uninstall_action ) && $update_uninstall_action || isset( $update_export_action ) && $update_export_action ) : ?>
	 <div id="message" class="updated">
	  <p>Settings updated.</p> 
	 </div>
		<?php
	else :
	?>
		<div id="message" class="updated">
			<p>Failed to update settings.</p> 
		</div>
	<?php
	endif;
endif;

if ( isset( $_GET['action'] ) && $_GET['action'] == 'update_whtp_database' && wp_verify_nonce( $_GET['whtp_nonce'], 'whtp_update_db' ) ) :
	include_once WHTP_PLUGIN_DIR_PATH . 'includes/config.php';
	include_once WHTP_PLUGIN_DIR_PATH . 'includes/installer.php';
	WHTP_Installer::update_count();
	WHTP_Installer::create();

	if ( get_option( 'whtp_hits_count_renamed' ) == 'yes' && get_option( 'whtp_countries_count_renamed' ) == 'yes' ) :
	?>
	<div id="message" class="updated">
	 <p>Database updated. Enjoy!</p> 
	</div>
	<?php
	endif;
endif;
?>
<div class="wrap">
	<h2 class="mdl-card__title-text">
	<?php esc_attr_e( 'Settings', 'whtp' ); ?>
	</h2>
</div>

<form action="" name="" method="post">    
	<div class="whtp-card-container mdl-grid">        
		<div class="mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-cell--12-col-phone mdl-card mdl-shadow--3dp">
			<div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
				<?php esc_attr_e( 'Uninstall Settings!', 'whtp' ); ?>
			</div>
			<div class="mdl-card__supporting-text">
				What should happen when you un-install the plugin?
			</div>
			<div class="mdl-card__supporting-text">
				<p>
					<input type="radio" name="uninstall-action" value="delete-all" 
		<?php
		if ( $option == 'delete-all' ) {
			echo 'checked';
		}
?>
  />
					<strong>Delete all Tables</strong> and <strong>Data</strong>
				</p>
				<p>
					<input type="radio" name="uninstall-action" value="clear-tables"
		<?php
		if ( $option == 'clear-tables' ) {
			echo 'checked';
		}
?>
  />
					<strong>Clear data</strong>, leave table structures.
				</p>
				<p>
					<input type="radio" name="uninstall-action" value="do-nothing"
		<?php
		if ( $option == 'do-nothing' ) {
			echo 'checked';
		}
?>
  />
					<strong>Leave all</strong> tables and data
				</p>
			</div>
			<div class="mdl-card__actions">
				<input type="hidden" name="update-uninstall-option" value="update-uninstall-option" /> 
				<input type="submit" value="Update Options" class="whtp-link mdl-button mdl-js-button mdl-typography--text-uppercase" />
			</div>
		</div>

		<div class="mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-cell--12-col-phone mdl-card mdl-shadow--3dp">
			<div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
				<?php esc_attr_e( 'Backup Settings', 'whtp' ); ?>
			</div>
			<div class="mdl-card__supporting-text">
				What should happen when you restore a backup?
			</div>
			<div class="mdl-card__supporting-text">
				<p>
					<input type="radio" name="backup-action" value="delete-all"
		<?php
		if ( $export_option == 'delete-all' ) {
			echo 'checked';
		}
?>
  />
					<strong>Override</strong> existing data 
				</p>
				<p>
					<input type="radio" name="backup-action" value="clear-tables"
		<?php
		if ( $export_option == 'clear-tables' ) {
			echo 'checked';
		}
?>
  />
					<strong>Update</strong> existing data, <strong>accumulate</strong> counts
				</p>
				<p>
					<input type="radio" name="backup-action" value="do-nothing"
		<?php
		if ( $export_option == 'do-nothing' ) {
			echo 'checked';
		}
?>
  />
					<strong>Skip/Ignore</strong> Existing Records
				</p>
			</div>
			<div class="mdl-card__actions">
				<input type="hidden" name="update-backup-options" value="update-backup-options" /> 
				<input type="submit" value="Update Options" class="whtp-link mdl-button mdl-js-button mdl-typography--text-uppercase" />
			</div>
		</div>

	<?php do_action( 'whtp-settings-after' ); ?>
	</div>
</form>

<div class="mdl-color--white mdl-cell mdl-cell--12-col">
	<div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
		<div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
	<?php esc_attr_e( 'Tools', 'whtp' ); ?>
		</div>
		<div class="mdl-card__supporting-text mdl-color-text--grey-600">
			<a href="<?php echo admin_url( 'admin.php?page=whtp-force-update' ); ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color--teal-300" target="_blank">
				<?php esc_attr_e( 'Click here to Force Database Update', 'whtp' ); ?>
			</a>            
		</div>
	</div>  
</div>
