<h2 class="mdl-card__title-text"><?php esc_attr_e( 'Help and Support', 'whtp' ); ?></h2>
<div class="notice notice-update update-nag is-dismissible">
	<p>
	<?php
	printf(
		__( 'We notice that you have updated the plugin! We need to update the database to make sure the plugin works as it should. <a href="%s" class="button">Click here to update database</a>', 'whtp' ),
		admin_url( 'admin.php?page=whtp-settings&action=update_whtp_database&whtp_nonce=' . wp_create_nonce( 'whtp_update_db' ) )
	);
	?>
		</p>
</div>
