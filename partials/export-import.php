<?php
	/*
	* define backup directory
	*/
	if ( !defined ( 'WHTP_BACKUP_DIR' ) ){
		WHTP_Functions::make_backup_dir ();
	}	
	$recent_backups = array();
	/*
	* $out = fopen('php://output','w'); to send output to the browser_id
	* Functions to import and export csv files
	*/
	function whtp_write_csv($file_name, array $list, $delimeter = ",", $enclosure = '"'){
		$handle = fopen( $file_name, "w" );	
		foreach ( $list as $fields ){
			if ( fputcsv ( $handle, $fields ) ) $done = true; // flag successful write
			else $done = false; // flag failed write
		}
		/*
		fputcsv( $out, $list );*/
		fclose( $handle );
		return $done; // return success or failed as true/false
	}
	
	
	/*
	* export the hits table to a CSV file
	* uses the function whtp_write_csv
	* returns the file's url and file name as an array
	*/
	function whtp_export_hits( $backup_date ){
		global $wpdb;
		$filename_url = WHTP_BACKUP_DIR;		
		$filename = $filename_url . "/" . $backup_date . "/whtp-hits.csv";
		$hits = $wpdb->get_results ( "SELECT * FROM whtp_hits" );
		
		$fields = array(); // csv rows / whole document
		if ( count ( $hits ) ){			
			foreach ( $hits as $hit  ){				
				$csv_row  = array($hit->page,$hit->count);	 // new row				
				$fields[] = $csv_row; // append row to others
			}
			//whtp_write_csv( $filename, $fields);
			if ( whtp_write_csv( $filename, $fields) ){
				$export_url = WP_CONTENT_URL . '/uploads/whtp_backups/' . $backup_date . "/whtp-hits.csv";
				echo '<p>Page "Hits" backup successful.</p>';
			}
		}
		return $recent_backup = array( 'link'=>$export_url, 'filename'=>'whtp-hits' );
		
	}
	
	/*
	* export the hitinfo table to a CSV file
	* uses the function whtp_write_csv
	* returns the file's url and file name as an array
	*/
	function whtp_export_hitinfo( $backup_date ){
		global $wpdb;
		$filename_url = WHTP_BACKUP_DIR;		
		$filename = $filename_url . "/" . $backup_date . "/whtp-hitinfo.csv";
		
		$hitsinfo = $wpdb->get_results ( "SELECT * FROM whtp_hitinfo" );
		
		$fields = array(); // csv rows / whole document
		if ( count( $hitsinfo ) > 0 ){			
			foreach ( $hitsinfo as $hitinfo  ){
				$csv_row  = array(
					$hitinfo->ip_address,$hitinfo->ip_total_visits,
					$hitinfo->user_agent,$hitinfo->datetime_first_visit,
					$hitinfo->datetime_last_visit
				);	 // new row				
				$fields[] = $csv_row;	 // new row;				
			}
			if ( whtp_write_csv( $filename, $fields) ){
				$export_url = WP_CONTENT_URL . '/uploads/whtp_backups/' . $backup_date . "/whtp-hitinfo.csv";
				echo '<p>Hitinfo backup successful.</p>';
			}	
		}
		return $recent_backup = array( 'link'=>$export_url, 'filename'=>'whtp-hitinfo' );
	}
	
	/*
	* export the user_agents table to a CSV file
	* uses the function whtp_write_csv
	* returns the file's url and file name as an array
	*/
	function whtp_export_user_agents( $backup_date ){
		global $wpdb;
		$filename_url = WHTP_BACKUP_DIR;		
		$filename = $filename_url . "/" . $backup_date . "/whtp-user-agents.csv";
		
		$user_agents = $wpdb->get_results ( "SELECT * FROM whtp_user_agents" );
		$fields = array();
		
		if ( count( $user_agents ) > 0 ){			
			foreach ( $user_agents as $user_agent  ){
				$csv_row  = array($user_agent->agent_id,$user_agent->agent_name,$user_agent->agent_details);				
				$fields[] = $csv_row;
			}	
			// write to csv
			//whtp_write_csv( $filename, $fields);
			if ( whtp_write_csv( $filename, $fields) ){
				$export_url = WP_CONTENT_URL . '/uploads/whtp_backups/' . $backup_date . "/whtp-user-agents.csv";
				echo '<p>User Agents backup successful.</p>';
			}	
		}
		return $recent_backup = array( 'link'=>$export_url, 'filename'=>'whtp-user-agents' );	
	}
	
	/*
	* export the ip_hits table to a CSV file
	* uses the function whtp_write_csv
	* returns the file's url and file name as an array
	*/
	function whtp_export_ip_hits( $backup_date ){
		global $wpdb;
		$filename_url = WHTP_BACKUP_DIR;		
		$filename = $filename_url . "/" . $backup_date . "/whtp-ip-hits.csv";
		
		$ip_hits = $wpdb->get_results( "SELECT * FROM whtp_ip_hits" );
		$fields = array();
		if ( count( $ip_hits ) > 0 ){			
			foreach ( $ip_hits as $ip_hit  ){
				$csv_row  = array(
					$ip_hit->ip_id,
					$ip_hit->page_id,
					$ip_hit->datetime_first_visit,
					$ip_hit->datetime_last_visit,
					$ip_hit->browser_id
				);
				$fields[] = $csv_row;
			}
			if ( whtp_write_csv( $filename, $fields, ',', '') ){
				$export_url = WP_CONTENT_URL . '/uploads/whtp_backups/' . $backup_date . "/whtp-ip-hits.csv";
				echo '<p>IP Hits Table backup successful.</p>';
			}	
		}
		return $recent_backup = array( 'link'=>$export_url, 'filename'=>'whtp-ip-hits' );
	}
?>

<div class="wrap">	
	<h2>Who Hit The Page Hit Counter</h2>
    <p></p>
    <div id="poststuff" class="metabox-holder has-right-sidebar">
        <div id="side-info-column" class="inner-sidebar">
            <div id="side-sortables" class="meta-box-sortables ui-sortable">
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Support</h3>
                    <div class="inside welcome-panel-column welcome-panel-last">
                       <h4>Donate $10 via 2Checkout</h4>
                        <p>Any Amount is highly Appreciated</p>
                        <form action='https://www.2checkout.com/checkout/purchase' method='post'>
                          <input type='hidden' name='sid' value='102959491'>
                          <input type='hidden' name='quantity' value='1'>
                          <input type='hidden' name='product_id' value='9'>
                          <label>Quantity</label>
                          <input name='quantity' type='text' size='5' value="1">
                          <input name='submit' type='submit' class="button button-primary" value='Donate through 2CO'>
                        </form>
                        <span>2Checkout.com Inc. (Ohio, USA) is a payment facilitator for goods and services provided by Three Pixels Web Solutions.</span>
                    </div>  
                </div>
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Subscribe to updates</h3>
                    <div class="inside welcome-panel-column welcome-panel-last">
					   <?php
                            if(isset($_POST['whtpsubscr']) && $_POST['whtpsubscr'] == "y"){
                                WHTP_Functions::whtp_admin_message_sender();
                            }
                            WHTP_Functions::signup_form();
                        ?>
                        <p>Thank you once again!</p>
                    </div>
                </div>
                
                <div class="postbox">
                    <div class="handlediv" title="Click to toggle"><br /></div>
                    <h3 class="hndle">Please Rate this plugin</h3>
                    <div class="inside welcome-panel-column welcome-panel-last">
                        <p><b>Dear User</b></p>
                        <p>Please 
                        <a href="http://wordpress.org/support/view/plugin-reviews/who-hit-the-page-hit-counter">Rate this plugin now.</a> if you appreciate it.
                        Rating this plugin will help other people like you to find this plugin because on wordpress plugins are sorted by rating, so rate it high and give it a fair review to help others find it.<br />
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="post-body">
            <div id="post-body-content">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                	<div class="postbox inside">
                    	<div class="handlediv" title="Click to toggle"><br /></div>
						<h3 class="hndle">Import / Export</h3>
    					<div class="inside">
                        	<!-- --> 
                            <div id="welcome-panel" class="welcome-panel">
                                <div class="welcome-panel-content">
                                    <div class="welcome-panel-column-container">
                                        <!-- Import to CSV -->
                                        <div class="welcome-panel-column" style="padding-right: 25px;">
                                            <h4>Export All Now</h4>
                                            <?php
                                                if ( !defined ('WHTP_BACKUP_DIR'  ) ){
                                                    if (WHTP_Functions::make_backup_dir () ){
                                                        echo '<div class="success"><p>Backup directory setup complete. Now you can backup your data and CSV files will be saved on : ' . WHTP_BACKUP_DIR . '</p></div>';	
                                                    }
                                                }
                                                else {
                                                    
                                                    //make folder for this new backup
                                                    $backup_date = date("Y-m-d") . '-' . date('H-i-s');
                                                    wp_mkdir_p ( WHTP_BACKUP_DIR . '/' . $backup_date );
                                                
                                                
                                                    if ( isset( $_POST["export-all"] ) ) {
                                                        echo '<div class="success"><p>';
                                                        // export hits table (page, count)
                                                        $recent_backups[] = whtp_export_hits ( $backup_date );
                                                        
                                                        // export hitinfo table (ip_address, ip_total_count, user_agent, datetime_first_visit, atetime_last_visit)
                                                        $recent_backups[] = whtp_export_hitinfo( $backup_date );
                                                        
                                                        // export user agents (agent_name, agent_details)
                                                        $recent_backups[] = whtp_export_user_agents( $backup_date );
                                                        
                                                        // export ip hits
                                                        $recent_backups[] = whtp_export_ip_hits( $backup_date );
                                                        
                                                        
                                                        
                                                        update_option('whtp_recent_backups', $recent_backups);
                                                        
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
                                        <div class="welcome-panel-column" style="padding-right: 25px;">
                                            <h4>Most Recent Backups</h4>
                                            <?php
                                                $recent_backups = get_option('whtp_recent_backups');
                                            if ( count ( $recent_backups ) > 0 ) {
                                                echo "<div><p>The most recent backups are shown here, ealier backups may be found in the folder/directory <br /><code>&lt;sitename&gt;wp-content/uploads/whtp_backups</code></p>";
                                            ?>	
                                            <ul>
                                                <?php
                                                $num_backups = count( $recent_backups );
                                                if (  $num_backups > 0 ){
                                                    for ($count = 0; $count < $num_backups ; $count ++){
                                                        echo '<li>
                                                                    <div class="welcome-icon icon-download">
                                                                        <a href="' 
                                                                            . $recent_backups[$count]['link'] . '">
                                                                                [download] ' 
                                                                            . $recent_backups[$count]['filename'] 
                                                                        . '</a>
                                                                    </div>
                                                            </li>';	
                                                        
                                                    }	
                                                }else{
                                                    echo "<div><p>There are no backups recently created</p></div>";
                                                }
                                                echo "</div>";
                                                ?>
                                            </ul>
                                            <?php 
                                            
                                            } else{
                                                echo '<p>There are no backups created. To create a backup, click "Export All Data" to start the export</p>';
                                            }?>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                      	</div>
                  	</div>
					<div class="postbox inside">
                    	<div class="handlediv" title="Click to toggle"><br /></div>
						<h3 class="hndle">Import Geo Location Data</h3>
                        <div class="inside">
                        	<!-- --> 
                            <div id="welcome-panel" class="welcome-panel">
                                <div class="welcome-panel-content">
                                    <div class="welcome-panel-column-container">
                                        <!-- Import to CSV -->
                                        <div class="welcome-panel-column" style="padding-right: 25px;">
                                            <h4>Import Location Data</h4>
                                            <?php
                                                                                            
                                                function whtp_import_using_sql_files(){
                                                    global $wpdb;                                                    
                                                    							
													$file	= WP_PLUGIN_DIR . '/who-hit-the-page-hit-counter/geodata/whtp_ip2location.sql';
													if ( is_file ( $file ) ){
														$fp 	= fopen($file, 'r');
														if ( $fp ) {
															$sql 	= fread($fp, 100000000);										
															$queries = explode(";", $sql);
															
															foreach ( $queries as $sql ){
																if ( $sql != "" ){
																	$wpdb->query( $sql );
																}
															}
															echo '<div class="updated"><p>Import Completed Successfully</p></div>';
														}
													}else{
														echo "<p>The .sql file was not found. Please make sure you have a file named 'whtp_ip2location.sql' inside the 'geodata' folder located within the folder of this plugin.</p>";	
													}
                                                }
                                                function whtp_import_from_csv_file(){
													global $wpdb;
                                                    $file = WHTP_GEODATA_URL . 'GeoIPCountryWhois.csv';
													echo "FILE: ". $file;
                                                    //echo "<p>Importing from Temp CSV : <br /><code>" . $file . "</code></p>";
                                                    echo "<p><strong>Please Wait</strong></p>";
                                                    
                                                    //open the file
                                                    $handle = fopen($file, "r");
                                                    if ( $handle ){								
                                                        //loop
                                                        while ( !feof( $handle ) ){
                                                            $row_number = 0;
                                                            $data = fgetcsv ( $handle, 1000, ",", '"');
                                                            if ( !empty ( $data ) ){
                                                                $insert = $wpdb->query( "INSERT INTO whtp_ip2location ( ip_from, ip_to, decimal_ip_from, decimal_ip_to, country_code, country_name ) VALUES
                                                                (
                                                                    '" . addslashes ( $data[0] ) . "',
                                                                    '" . addslashes ( $data[1] ) . "',
                                                                    '" . addslashes ( $data[2] ) . "',
                                                                    '" . addslashes ( $data[3] ) . "',
                                                                    '" . addslashes ( $data[4] ) . "',
                                                                    '" . addslashes ( $data[5] ) . "'
                                                                )" );
                                                            }
                                                        }
                                                        echo '<div class="success"><p>Import Completed Successfully</p></div>';
                                                    }
                                                    else{
                                                        echo "<p>File 'GeoIPCountryWhois.csv' was not found. Please make sure you have a file named 'GeoIPCountryWhois.csv' inside the 'geodata' folder located within the folder of this plugin.</p>";
                                                    }
                                                }
                                                
                                                if ( isset ( $_POST['import-geo'] ) ){
                                                    whtp_import_using_sql_files();
                                                    //whtp_import_from_csv_file();
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
                                        <?php if ( get_option( whtp_vc_updated) == true ): ?>
                                        <div class="welcome-panel-column" style="padding-right: 25px;">
                                            <h4>Merge existing records</h4>
                                            <?php
												if ( isset ( $_POST['count-old-countries'] ) && $_POST['count-old-countries'] == 'count-old-countries' ){
													if ( get_option('whtp_vc_updated') == false ){
														if ( WHTP_Hit_Info::update_countries() ){
															update_option('whtp_vc_updated', 'true');
															echo '<div class="row"><p class="updated">Records updated successfully.</p></div>';
														}
													}
													else{
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
       </div>
 </div>       