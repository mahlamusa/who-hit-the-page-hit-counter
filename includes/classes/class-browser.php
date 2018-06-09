<?php

class WHTP_Broswer extends WHTP_Database{
    public function __construct(){
        parent::_construct();
    }

    /*
    *	Get agent id
    */
    function get_agent_id($browser){
        global $wpdb;
        $ua_id = $wpdb->get_var("SELECT agent_id FROM `{self::$user_agents_table}` WHERE agent_name = '$browser' LIMIT 1");
        if ( $ua_id ){
            return $ua_id;
        }
        else{
            return "Unknown Browser";	
        }
    }

    function browser_exists( $browser ){
        global $wpdb;
        $browser = $wpdb->get_var("SELECT agent_name FROM `{self::$user_agents_table}` WHERE agent_name='$browser' LIMIT 1" );
        if ($browser){
            return true;
        }
        else return false;
    }

    public static function add_browser($browser, $details = ""){
        global $wpdb;
        $wpdb->insert(
            self::$user_agents_table, 
            array(
                "agent_name"    => $browser, 
                "agent_details" => $details
            ), array("%s", "%s") 
        );	
    }

    public static function get_browsers(){
       return $wpdb->get_results ( "SELECT agent_name FROM `{self::$user_agents_table}`" );
    }
}