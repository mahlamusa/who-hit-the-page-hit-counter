<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_Hits{
    public static $hits_table;

    public function __construct(){        
        global $wpdb;
        self::$hits_table = $wpdb->prefix . 'whtp_hits';
    }

    public static function total(){
        global $wpdb, $hits_table;

        $total = $wpdb->get_var( "SELECT SUM(count_hits) AS totalhits FROM $hits_table" );

        if ( $total ) return $total;
        else return 0;
    }

    public static function get_hits( $offset = 0, $number = 15, $order = 'DESC') {
        global $wpdb, $hits_table;

        $sql = "SELECT * FROM `$hits_table` ORDER BY count_hits $order";

        $sql = ( $number != 'all' ) ? $sql . " LIMIT $offset, $number" : $sql;

        $all = $wpdb->get_results( $sql );

        if ( $all ) return $all;
        else return (object) array();
    }

    public static function get_page_by_id( $page_id ) {
        global $wpdb, $hits_table;

        return $wpdb->get_row ( "SELECT * FROM `$hits_table` WHERE page_id='$page_id' LIMIT 0,1" );
    }

    public static function count_page( $page ) {	
        $page = $page;
        
        $ip_address	= $_SERVER["REMOTE_ADDR"];	# visitor's ip address 
        
        #count if the IP is not denied
        if ( ! WHTP_Hit_Info::ip_is_denied ( $ip_address ) ) {
            $page = $page;
            self::count_hits( $page );
            WHTP_Hit_Info::hit_info( $page );
        }
    }

    public static function discount_page(){
        global $wpdb, $hits_table;

        $page = stripslashes( $_POST['discount_page'] );
        $discountby = stripslashes( $_POST['discountby'] );
        $old_count = $wpdb->get_var( "SELECT count_hits FROM `$hits_table` WHERE page='$page'" );
        
        $discount_page = $wpdb->update(
            WHTP_HITS_TABLE, 
            array( "count_hits" => $old_count - $discountby ), 
            array("page" => $page)
        );
        
        if ( $discount_page ) return true;
        else return false;
    }

    /*
    * Check if the page has been visited then
    * update or create new counter
    */
    public static function count_hits( $page ){
        global $wpdb, $hits_table;

        $page = $page;
        
        //$ua = getBrowser(); //Get browser info
        $ua = WHTP_Browser::browser_info();
        $browser = $ua['name'];
            
        $page_check = $wpdb->get_var("SELECT page FROM `$hits_table` WHERE page = '$page' LIMIT 1");
        if ( $page_check != "" ){
            $count = $wpdb->get_var("SELECT count_hits FROM `$hits_table` WHERE page = '$page' LIMIT 1");
            $ucount = $count + 1;
            $update = $wpdb->update(
                WHTP_HITS_TABLE,
                array("count_hits"=> $ucount), 
                array("page"=>$page),array("%d"),array("%s"));
        }
        else {
            $insert = $wpdb->insert(
                WHTP_HITS_TABLE, 
                array("page"=>$page,"count_hits"=>1), 
                array("%s", "%d")
            );
            $page_id = $wpdb->insert_id;
            $_SESSION['insert_page'] = $page_id;
        }
        if ( !  WHTP_Browser::browser_exists( $browser ) ){
            WHTP_Browser::add_browser( $browser );
        }
    }

    public static function get_page_id ( $page ){
        global $wpdb, $hits_table;

        $page_id  = $wpdb->get_var(
            "SELECT page_id FROM `$hits_table` 
            WHERE page = '$page' LIMIT 1"
        );
        return $page_id;
    }

    public static function delete_page( $delete_page = ""){
        global $wpdb, $hits_table;

        if ($delete_page == ""){
            $delete_page = isset( $_GET['delete_page'] ) ? esc_attr( $_GET['delete_page'] ) : esc_attr( $_POST['delete_page'] );
        }
        
        if ( $delete_page != "all" ){
            $del = $wpdb->query ("DELETE FROM `$hits_table` WHERE page='$delete_page'");
        }
        else{
            $del = $wpdb->query("DELETE * FROM `$hits_table`");
        }

        if ( $del ) return true;
        else return false;
    }

    public static function reset_page_count( $page = ""){
        global $wpdb, $hits_table;

        if ( $page == ""){
            $page = isset( $_GET['reset_page'] ) ? esc_attr( $_GET['reset_page'] ) : esc_attr( $_POST['reset_page'] );
        }
        if( $page != "all" ){
            #don't reset all but specific page
            $update_page = $wpdb->query("UPDATE `$hits_table` SET count_hits = 0 WHERE page = '$page'");
            
        }else{
            #reset all
            $update_all = $wpdb->query("UPDATE `$hits_table` SET count_hits = 0 ");
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