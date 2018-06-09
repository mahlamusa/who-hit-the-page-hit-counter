<?php

class WHTP_Hits extends WHTP_Database{
    public function __construct(){
        parent::__construct();
    }

    public static function total(){
        global $wpdb;

       $total = $wpdb->get_var( "SELECT SUM(count) AS totalhits FROM {self::$hits_table}" );
       if ( $total ) return $total;
       else return 0;
    }

    public static function get_hits( $page = 0, $number = "") {
        global $wpdb;

        $all = $wpdb->get_results("SELECT * FROM `{self::$hits_table}` ORDER BY count DESC");
        if ( $all ) return $all;
        else return (object) array();
    }

    public static function get_page_by_id( $page_id ) {
        global $wpdb;
        return $wpdb->get_row ( "SELECT page, count FROM `{self::$hits_table}` WHERE page_id='$page_id' LIMIT 0,1" );
    }

    public static function count_page( $page ) {        	
        $page = $page;
        
        $ip_address	= $_SERVER["REMOTE_ADDR"];	# visitor's ip address 
        
        #count if the IP is not denied
        if ( !ip_is_denied ( $ip_address ) ) {
            $page = $page;
            self::count_hits( $page );
            WHTP_Hit_Info::hit_info( $page );
        }
    }

    /*
    * Check if the page has been visited then
    * update or create new counter
    */
    public static function count_hits( $page ){
        global $wpdb;
        $page = $page;
        
        //$ua = getBrowser(); //Get browser info
        $ua = whtp_browser_info();
        $browser = $ua['name'];
            
        $page_check = $wpdb->get_var("SELECT page FROM `{self::$hits_table}` WHERE page = '$page' LIMIT 1");
        if ( $page_check != "" ){
            $count = $wpdb->get_var("SELECT count FROM `{self::$hits_table}` WHERE page = '$page' LIMIT 1");
            $ucount = $count + 1;
            $update = $wpdb->update(
                self::$hits_table,
                array("count"=> $ucount), 
                array("page"=>$page),array("%d"),array("%s"));
        }
        else {
            $insert = $wpdb->insert(
                self::$hits_table, 
                array("page"=>$page,"count"=>1), 
                array("%s", "%d")
            );
            $page_id = $wpdb->insert_id;
            $_SESSION['insert_page'] = $page_id;
        }
        if ( !  WHTP_Broswer::browser_exists( $browser ) ){
            WHTP_Broswer::add_browser( $browser );
        }
    }

    

    

    function get_page_id ( $page ){
        global $wpdb;

        $page_id  = $wpdb->get_var(
            "SELECT page_id FROM {self::$hits_table} 
            WHERE page = '$page' LIMIT 1"
        );
        return $page_id;
    }

    public static function delete_page( $delete_page = ""){
        global $wpdb;

        if ($delete_page == ""){
            $delete_page = esc_attr( $_POST['delete_page'] );
        }
        
        if ( $delete_page != "all" ){
            $del = $wpdb->query ("DELETE FROM `{self::$hitinfo_table}` WHERE page='$delete_page'");
        }
        else{
            $del = $wpdb->query("DELETE * FROM `{self::$hitinfo_table}`");
        }

        if ( $del ) return true;
        else return false;
    }

    public static function reset_page_count( $page = ""){
        global $wpdb;
        if ( $page == ""){
            $page = stripslashes( $_POST['reset_page'] );
        }
        if( $page != "all" ){
            #don't reset all but specific page
            $update_page = $wpdb->query("UPDATE `{self::$hitinfo_table}` SET count = 0 WHERE page = '$page'");
            
        }else{
            #reset all
            $update_all = $wpdb->query("UPDATE `{self::$hitinfo_table}` SET count = 0 ");
            if ( $update_all ) {
                $update_hit_info = WHTP_Hit_Info::reset_ip_info("all");
            }
        }
        
        if ( $update_page || $update_all || $update_hit_info ) return true;
        else return false;
    }
}

function who_hit_the_page( $page ) {
    WHTP_Counter::count_page( $page );
}
function whtp_count_hits( $page ){
    WHTP_Counter::count_hits( $page );
}
function whtp_hit_info( $page ){
    WHTP_Counter::hit_info( $page );
}