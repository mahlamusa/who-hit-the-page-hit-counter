<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_Hit_Info{
    private static $hitinfo_table;
    
    public function __construct(){
        global $wpdb;
        
        self::$hitinfo_table	= $wpdb->prefix . 'whtp_hitinfo';
    }

    public static function get_hitinfo( $offset = 0, $number = 15, $status = 'active' ){
        global $wpdb, $hitinfo_table;

        $sql = "SELECT * FROM `$hitinfo_table` 
        WHERE ip_status='$status' 
        ORDER BY ip_total_visits DESC";

        $sql = $number != 'all' ? $sql . " LIMIT $offset, $number" : $sql;
        
        $hits = $wpdb->get_results( $sql );

        if ( $hits ) return $hits;
        else return array();
    }

    public static function count( $status = 'active'){
        global $wpdb, $hitinfo_table;

        $count = $wpdb->get_var("SELECT COUNT(ip_address) FROM `$hitinfo_table` WHERE ip_status='{$status}'");

        if ( $count ) return $count;
        else return 0;
    }
    /*
    * Get entries fro old hitinfo table
    * count the existing ips into the country count
    */
    public static function update_count_visiting_countries(){
        global $wpdb, $hitinfo_table;

        $ips  = $wpdb->get_results("SELECT ip_address FROM `$hitinfo_table` WHERE ip_status = 'active'");
        if ( $ips ){
            foreach ($ips as $ip ){
                $country_code = WHTP_IP_Location::get_country_code( $ip->ip_address );
                if ( WHTP_Visiting_Countries::country_count( $country_code ) )
                    return true;
                else return false;				
            }
        }

        return false;
    }

    public static function get_ip_id( $ip_address ){
        global $wpdb, $hitinfo_table;

        $ip_id  = $wpdb->get_var("SELECT id FROM `$hitinfo_table` WHERE ip_address='$ip_address' LIMIT 1");			
        if ($ip_id){
            return $ip_id;
        }
    }

    public static function reset_ip_info( $resetips = ""){	
        global $wpdb, $hitinfo_table;

        if ( isset ( $_POST['ip_address'] ) )
            $ip_address = $_POST['ip_address'];
            
        if ($resetips == ""){
            $reset_ip = $resetips;
        }else{
            $reset_ip = stripslashes( $_POST['reset_ip'] );
        }

        if ($reset_ip != "all" && isset( $ip_address )){
            # reset specific
            $reset = $wpdb->update(
                $hitinfo_table, 
                array("ip_total_visits" => 0),
                array("ip_address" => $ip_address), 
                array("%d"), array("%s")
            );
        }
        else{
            # reset all ip counters
            $reset_all = $wpdb->query( "UPDATE `$hitinfo_table` SET ip_total_visits = 0");
        }
        
        if ( $reset || $reset_all ) return true;
        else return false;

    }
    
    # delete ip address
    public static function delete_ip ( $ip, $all = "" ){
        global $wpdb, $hitinfo_table;
        
        if ( $delete_ip == "this_ip" ) {
            $del = $wpdb->query ("DELETE FROM `$hitinfo_table` WHERE ip_address='$ip_address'");
            
                
        }
        elseif ( $delete_ip == "all" ){
            $del = $wpdb->query("DELETE FROM `$hitinfo_table`");            
        }

        if ( $del ) return true;
        else return false;
    }

    public static function hits_for_ip( $visitor_ip ) {
        global $wpdb, $hitinfo_table;

        return $wpdb->get_row(
            "SELECT * FROM `$hitinfo_table` 
            WHERE ip_address='$visitor_ip'"
        );
    }

    public static function get_ip_count_hits() {
        global $wpdb, $hitinfo_table;

        return $wpdb->get_results( 
            "SELECT ip_address, ip_total_visits 
            FROM $hitinfo_table 
            WHERE ip_status = 'active' 
            ORDER BY ip_total_visits DESC"
        );
    }

    public static function count_unique(){
        global $wpdb, $hitinfo_table;

        return $wpdb->get_var(
            "SELECT COUNT(ip_address) AS totalunique 
            FROM `$hitinfo_table` 
            WHERE ip_status='active'"
        );
    }

    public static function top( $number = 10) {
        global $wpdb, $hitinfo_table;

        return $wpdb->get_results( 
            "SELECT ip_address, ip_total_visits 
            FROM `$hitinfo_table` 
            WHERE ip_status='active' 
            ORDER BY ip_total_visits DESC LIMIT $number"
        );
    }

    /*
    * start gathering unique user data
    * and update the table
    */
    public static function hit_info( $page ){
        global $wpdb, $hitinfo_table;

        $page = $page;
        
        $ip_address			= $_SERVER["REMOTE_ADDR"];	# visitor's ip address
        $date_ftime 		= date("Y/m/d") . ' ' . date('H:i:s'); # visitor's first visit
        $date_ltime			= date("Y/m/d") . ' ' . date('H:i:s'); # visitor's last visit

        //MaxMind GeoIP2
        require_once WHTP_PLUGIN_DIR_PATH . 'vendor/autoload.php';

        use MaxMind\Db\Reader;

        $databaseFile = WHTP_PLUGIN_DIR_PATH . 'geodata/GeoIP2-City.mmdb';

        $reader = new Reader($databaseFile);

        print_r( $reader->get( $ip_ddress ) );

        $reader->close();
        
        //$ua = getBrowser(); //Get browser info
        $ua = WHTP_Browser::browser_info();
        $browser = $ua['name'];
        
        $page_id = WHTP_Hits::get_page_id( $page );
        /*
        * first check if the IP is in database
        * if the ip is not in the database, add it in
        * otherwise update
        */
        
        $ip_check  =  $wpdb->get_var( "SELECT ip_address FROM `$hitinfo_table` WHERE ip_address = '$ip_address'" );

        if ( $ip_check == ""){
            $insert_hit_info = $wpdb->insert(
                $hitinfo_table, 
                array(
                    "ip_address"            => $ip_address,
                    "ip_total_visits"       =>1,
                    "user_agent"            =>$browser,
                    "datetime_first_visit"  =>$date_ftime,
                    "datetime_last_visit"   =>$date_ltime
                ), 
                array("%s", "%d", "%s", "%s", "%s")
            );
                
                
            $ip_id      = $wpdb->insert_id;				
        }
        else{
            $ip_total_visits = $wpdb->get_var("SELECT ip_total_visits FROM `$hitinfo_table` WHERE ip_address = '$ip_address'");

            $ip_total_visits += 1;
            $update_ip_visit = $wpdb->update(
                $hitinfo_table, 
                array(
                    "ip_total_visits"       => $ip_total_visits, 
                    "user_agent"            => $browser, 
                    "datetime_last_visit"   => $date_ltime
                ),
                array("ip_address"=>$ip_address), 
                array("%d","%s","%s")
            );
        }
        
            
        $ua_id      = WHTP_Browser::get_agent_id( $browser );
        $ip_id      = WHTP_Hit_Info::get_ip_id( $ip_address );
        $page_id    = WHTP_Hits::get_page_id ( $page );
        
        if ( !  WHTP_Browser::browser_exists( $browser ) ){
            WHTP_Browser::add_browser( $browser );
        }
        WHTP_Ip_Hits::ip_hit( $ip_id, $page_id, $date_ftime, $ua_id ); //insert new hit

        // get the country code corresponding to the visitor's IP
        $country_code   = WHTP_IP_Location::get_country_code( $ip_address );
        $counted        = WHTP_Visiting_Countries::country_count( $country_code );
    }

    public static function ip_is_denied ( $ip_address ){
        global $wpdb, $hitinfo_table;
        $denied_ip	= $wpdb->get_var(
            "SELECT ip_address 
            FROM `$hitinfo_table` 
            WHERE ip_status='denied' AND ip_address='$ip_address' 
            LIMIT 1"
        );
        
        if ( $denied_ip && $denied_ip != "" ) return true;
        else return false;
    }
    
    # set an IP's status as denied
    public static function deny_ip( $ip_address = ""){
        global $wpdb, $hitinfo_table;

        $ip_address = $ip_address != "" ? $ip_address : esc_attr( $_POST['ip_address'] );
        
        $deny = $wpdb->update(
            $hitinfo_table, 
            array("ip_status"=>"denied"), 
            array("ip_address"=>$ip_address), array("%s"), array("%s")
        );
        
        if ( $deny ) return true;
        else return false;
           
    }

    public static function add_denied_ip(){
        global $wpdb, $hitinfo_table;
		
		$ip_address = stripslashes( $_POST['ip_address'] );
		
		$add_ip = $wpdb->insert(
            $hitinfo_table, 
            array("ip_status" => "denied" ,"ip_address" => $ip_address ), 
            array("%s", "%s", "%s")
        );
        
        if ( $add_ip ) return true;
        else return false;
    }
    
    public static function allow_ip(){
        global $wpdb, $hitinfo_table;

		$ip_address = stripslashes( esc_attr( $_POST['ip_address'] ) );
		
		$allow = $wpdb->update(
            $hitinfo_table, 
            array("ip_status"=>"active"), 
            array("ip_address"=>$ip_address), array("%s"), array("%s") 
        );
		
        if ( $allow ) return true;
        else return false;
	}
}