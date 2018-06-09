<?php
	/*
	* flag the plugin as not installed/uninstalled
	*/
	if(!update_option("whtp_installed","false")){ 
		add_option("whtp_installed","false","","yes");
	}
	
	
	/*
	* delete all data and table structures
	* if user have chosen to delete-all data and table
	*/
	if ( get_option("whtp_data_action") == "delete-all"){
		whtp_delete_all();
	}
	
	/*
	* clear all data but leave table structures intact
	* if the user have chosen to clear all data
	*/
	elseif( get_option("whtp_data_action") == "clear-tables"){
		whtp_empty_all();
	}
	/*
	* do nothing
	* if the user have chosen to do nothing about the tables and the data contained
	8 just return
	*/
	elseif ( get_option("whtp_data_action") == "do-nothing"){
		#do nothing
		return;
	}
	
	/*
	* Delete all data / Empty all tables
	* leave table structures
	*/
	function whtp_empty_all(){
		global $wpdb;
		$wpdb->query ( "TRUNCATE `whtp_hits`" 				);	
		$wpdb->query ( "TRUNCATE `whtp_hitinfo`" 			);
		$wpdb->query ( "TRUNCATE `whtp_user_agents`" 		);
		$wpdb->query ( "TRUNCATE `whtp_ip2location`" 		);
		$wpdb->query ( "TRUNCATE `whtp_visiting_countries`" );
		$wpdb->query ( "TRUNCATE `whtp_ip_hits`" 			);
	}
	
	/*
	* Delete all tables and their data
	*/
	function whtp_delete_all(){
		global $wpdb;
		$wpdb->query ( "DROP TABLE whtp_hits" 				);
		$wpdb->query ( "DROP TABLE whtp_hitinfo" 			);
		$wpdb->query ( "DROP TABLE whtp_user_agents" 		);
		$wpdb->query ( "DROP TABLE whtp_ip2location" 		);
		$wpdb->query ( "DROP TABLE whtp_visiting_countries" );
		$wpdb->query ( "DROP TABLE whtp_ip_hits" 			);
	}
?>