<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	$recent_backups = array();

?>

<div class="wrap">    
	<h2 class="mdl-card__title-text"><?php esc_attr_e( 'Export / Imports', 'whtp' ); ?></h2>
	<p></p>

	<div class="whtp-card-container mdl-grid">
		<div class="mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-cell--12-col-phone mdl-card">
			<div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
				<div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
		<?php esc_attr_e( 'Export All Now', 'whtp' ); ?>
				</div>
				<div class="mdl-card__supporting-text mdl-color-text--grey-600">
		<?php
		if ( ! defined( 'WHTP_BACKUP_DIR' ) ) {
			if ( WHTP_Functions::make_backup_dir() ) {
				echo '<div class="success"><p>Backup directory setup complete. Now you can backup your data and CSV files will be saved on : ' . WHTP_BACKUP_DIR . '</p></div>';
			}
		} else {
			if ( isset( $_POST['export-all'] ) ) {
				$backup_date = date( 'Y-m-d' ) . '-' . date( 'H-i-s' );
				wp_mkdir_p( WHTP_BACKUP_DIR . '/' . $backup_date );

				echo '<div class="success"><p>';
				// export hits table (page, count_hits)
				$recent_backups[] = WHTP_Functions::export_hits( $backup_date );

				// export hitinfo table (ip_address, ip_total_count, user_agent, datetime_first_visit, atetime_last_visit)
				$recent_backups[] = WHTP_Functions::export_hitinfo( $backup_date );

				// export user agents (agent_name, agent_details)
				$recent_backups[] = WHTP_Functions::export_user_agents( $backup_date );

				// export ip hits
				$recent_backups[] = WHTP_Functions::export_ip_hits( $backup_date );

				update_option( 'whtp_recent_backups', $recent_backups );

				echo '</p></div>';
			}
		}
		?>
					<form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
						<p>Clicking "Export All Data" will generate CSV files and save them in a folder: <br />
						<code>&lt;site-or-blog-url&gt;wp-content/uploads/whtp_backups/&lt;YEAR-MONTH-DAY-HOUR-MINUTE-SECOND&gt;</code>
							which you may access using an FTP client. The download links are shown on this page to download the most recent CSVs.</p>
						
						<input name="export-all" value="export-all" type="hidden" />
						<p><input class="button button-primary button-hero" type="submit" name="submit" value="Export All Data" /></p>
					</form>
				</div>
			</div>  
		</div>

		<div class="mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-cell--12-col-phone mdl-card">
			<div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
				<div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
		<?php esc_attr_e( 'Most Recent Backups', 'whtp' ); ?>
				</div>
				<div class="mdl-card__supporting-text mdl-color-text--grey-600">
		<?php
		$recent_backups = get_option( 'whtp_recent_backups' );
		if ( count( $recent_backups ) > 0 ) :
		?>
		 <p>The most recent backups are shown here, ealier backups may be found in the folder/directory <br /><code>&lt;sitename&gt;wp-content/uploads/whtp_backups</code></p>    
		<ul>
			<?php
			$num_backups = count( $recent_backups );
			if ( $num_backups > 0 ) :
				for ( $i = 0; $i < $num_backups; $i ++ ) :
				?>
				<li>
				 <div class="welcome-icon icon-download">
				  <a href="<?php echo $recent_backups[ $i ]['link']; ?>">
				<?php echo $recent_backups[ $i ]['filename']; ?>
									</a>
								</div>
				</li>
				<?php
				endfor;
		 else :
			?>
		  <div><p>There are no backups recently created</p></div>
			<?php
		 endif;
			?>
		</ul>
		<?php

					else :
						echo '<p>There are no backups created. To create a backup, click "Export All Data" to start the export</p>';
					endif;
		?>
					</div>
				</div>
			</div>            
		</div>








		<div class="mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-cell--12-col-phone mdl-card">
			<div class="whtp-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
				<div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
		<?php esc_attr_e( 'Import Geo Location Data', 'whtp' ); ?>
				</div>
				<div class="mdl-card__supporting-text mdl-color-text--grey-600">
					
				<div id="welcome-panel" class="welcome-panel">
					<div class="welcome-panel-content">
						<div class="welcome-panel-column-container">
							<!-- Import to CSV -->
							<div class="welcome-panel-column" style="padding-right: 25px;">
								<h4>Import Location Data</h4>
								<?php

								function whtp_import_using_sql_files() {
									global $wpdb;

									$file = WP_PLUGIN_DIR . '/who-hit-the-page-hit-counter/geodata/whtp_ip2location.sql';
									if ( is_file( $file ) ) {
										$fp = fopen( $file, 'r' );
										if ( $fp ) {
											$sql     = fread( $fp, filesize( $file ) );
											$queries = explode( ';', $sql );

											foreach ( $queries as $sql ) {
												if ( $sql != '' ) {
													$wpdb->query( $sql );
												}
											}
											echo '<div class="updated"><p>Import Completed Successfully</p></div>';
										}
									} else {
										echo "<p>The .sql file was not found. Please make sure you have a file named 'whtp_ip2location.sql' inside the 'geodata' folder located within the folder of this plugin.</p>";
									}
								}
								function whtp_import_from_csv_file() {
									global $wpdb;
									$file = WHTP_GEODATA_URL . 'GeoIPCountryWhois.csv';
									echo 'FILE: ' . $file;
									// echo "<p>Importing from Temp CSV : <br /><code>" . $file . "</code></p>";
									echo '<p><strong>Please Wait</strong></p>';

									// open the file
									$handle = fopen( $file, 'r' );
									if ( $handle ) {
										// loop
										while ( ! feof( $handle ) ) {
											$row_number = 0;
											$data       = fgetcsv( $handle, 1000, ',', '"' );
											if ( ! empty( $data ) ) {
												$insert = $wpdb->query(
													"INSERT INTO whtp_ip2location ( ip_from, ip_to, decimal_ip_from, decimal_ip_to, country_code, country_name ) VALUES
                                                    (
                                                        '" . addslashes( $data[0] ) . "',
                                                        '" . addslashes( $data[1] ) . "',
                                                        '" . addslashes( $data[2] ) . "',
                                                        '" . addslashes( $data[3] ) . "',
                                                        '" . addslashes( $data[4] ) . "',
                                                        '" . addslashes( $data[5] ) . "'
                                                    )"
												);
											}
										}
										echo '<div class="success"><p>Import Completed Successfully</p></div>';
									} else {
										echo "<p>File 'GeoIPCountryWhois.csv' was not found. Please make sure you have a file named 'GeoIPCountryWhois.csv' inside the 'geodata' folder located within the folder of this plugin.</p>";
									}
								}

								if ( isset( $_POST['import-geo'] ) ) {
									whtp_import_using_sql_files();
									// whtp_import_from_csv_file();
								}
								?>
								<form method="post" action="" enctype="multipart/form-data" name="form1" id="form1">
									<p>Click on the button below to start the import process.</p>                        
									<!-- <p><input type="file" name="csv" id="csv"  /></p> -->
									<p>
										<input type="hidden" name="import-geo" value="import-geo" />
										<input class="button button-primary button-hero" type="submit" name="submit" value="Import Geo Location Data" />
										</p>
										<p>Data provided by MaxMind <a href="http://www.maxmind.com">http://www.maxmind.com</a></p>
										
								</form>
							</div>
		<?php if ( get_option( whtp_vc_updated ) == true ) : ?>
							<div class="welcome-panel-column" style="padding-right: 25px;">
								<h4>Merge existing records</h4>
								<?php
								if ( isset( $_POST['count-old-countries'] ) && $_POST['count-old-countries'] == 'count-old-countries' ) {
									if ( get_option( 'whtp_vc_updated' ) == false ) {
										if ( WHTP_Hit_Info::update_countries() ) {
											update_option( 'whtp_vc_updated', 'true' );
											echo '<div class="row"><p class="updated">Records updated successfully.</p></div>';
										}
									} else {
										echo '<div class="row"><p class="updated">Records up to date. No action required.</p></div>';
									}
								}

								?>
								<div>
										<form method="post" action="" enctype="multipart/form-data" name="form2" id="form2">
									<p>This will match your existing IP Addresse from previous viersion with the geao location database to help you match the old entries with their respective countries as listed in the new database.</p>  
									<p>Please don't do this if you have already done so.</p>                      
									<!-- <p><input type="file" name="csv" id="csv"  /></p> -->
									<p>
										<input type="hidden" name="count-old-countries" value="count-old-countries" />
										<input class="button button-primary button-hero" type="submit" name="submit" value="Update Previous Records" />
										</p>                                                 
								</form>
								</div>
							</div>
		<?php endif; ?>
							<div class="welcome-panel-column" style="padding-right: 25px;">
								<h4>Credits Where They Belong</h4>
								<div>
									<p>This product includes GeoLite2 data created by MaxMind, available from
							<a href="http://www.maxmind.com">http://www.maxmind.com</a>.</p>
									<p><small>For the purpose of this project, I have converted the format of the data from 'CSV' to an 'SQL' file which this program executes to import the data, but the data contained remains unchanged and the same in both files.</small></p>
								</div>
							</div>
						</div>
					</div>
				</div>

				</div>
			</div>  
		</div>
	</div>   
