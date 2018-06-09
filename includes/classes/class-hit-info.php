<?php

class WHTP_Hit_Info extends WHTP_Database{
    public function __construct(){
        parent::__construct();
    }

    public static function get_hits( $page, $number ){
        $hits = $wpdb->get_results(
            "SELECT * FROM `{self::$hitinfo_table}` 
            WHERE ip_status='active' 
            ORDER BY ip_total_visits DESC"
        );

        if ( $hits ) return $hits;
        else return array();
    }

    public static function count(){
        $count = $wpdb->get_var("SELECT COUNT(ip_address) FROM `{self::$hitinfo_table}` WHERE ip_status='active'");

        if ( $count ) return $count;
        else return 0;
    }
    /*
    * Get entries fro old hitinfo table
    * count the existing ips into the country count
    */
    public static function update_count_visiting_countries(){
        global $wpdb;
        $ips  = $wpdb->get_results("SELECT ip_address FROM `{self::$hitinfo_table}` WHERE ip_status = 'active'");
        if ( $ips ){
            foreach ($ips as $ip ){
                $country_code = WHTP_IP_Location::sget_country_code( $ip->ip_address );
                if ( WHTP_Visiting_Countries::country_count( $country_code ) )
                    return true;
                else return false;				
            }
        }

        return false;
    }

    public static function get_ip_id( $ip_address ){
        global $wpdb;
        $ip_id  = $wpdb->get_var("SELECT id FROM `{self::$hitinfo_table}` WHERE ip_address='$ip_address' LIMIT 1");			
        if ($ip_id){
            return $ip_id;
        }
    }

    public static function reset_ip_info( $resetips = ""){	
        global $wpdb;
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
                self::$hitinfo_table, 
                array("ip_total_visits" => 0),
                array("ip_address" => $ip_address), 
                array("%d"), array("%s")
            );
        }
        else{
            # reset all ip counters
            $reset_all = $wpdb->query( "UPDATE `{self::$hitinfo_table}` SET ip_total_visits = 0");
        }
        
        if ( $reset || $reset_all ) return true;
        else return false;

    }
    
    # delete ip address
    public function delete_ip ( $ip, $all = "" ){
        global $wpdb;
        
        if ( $delete_ip == "this_ip" ) {
            $del = $wpdb->query ("DELETE FROM `{self::$hitinfo_table}` WHERE ip_address='$ip_address'");
            
                
        }
        elseif ( $delete_ip == "all" ){
            $del = $wpdb->query("DELETE FROM `{self::$hitinfo_table}`");            
        }

        if ( $del ) return true;
        else return false;
    }

    public static function hits_for_ip( $visitor_ip ) {
        return $wpdb->get_row(
            "SELECT * FROM `{self::$hitinfo_table}` 
            WHERE ip_address='$visitor_ip'"
        );
    }

    public static function count_unique(){
        return $wpdb->get_var(
            "SELECT COUNT(ip_address) AS totalunique 
            FROM `{self::$hitinfo_table}` 
            WHERE ip_status='active'"
        );
    }

    public static function top( $number = 10) {
        return $wpdb->get_results( 
            "SELECT ip_address, ip_total_visits 
            FROM `{self::$hitinfo_table}` 
            WHERE ip_status='active' 
            ORDER BY ip_total_visits DESC LIMIT '$number'"
        );
    }

    /*
    * start gathering unique user data
    * and update the table
    */
    public static function hit_info( $page ){
        global $wpdb;
        $page = $page;
        
        $ip_address			= $_SERVER["REMOTE_ADDR"];	# visitor's ip address
        $date_ftime 		= date("Y/m/d") . ' ' . date('H:i:s'); # visitor's first visit
        $date_ltime			= date("Y/m/d") . ' ' . date('H:i:s'); # visitor's last visit
        
        //$ua = getBrowser(); //Get browser info
        $ua = whtp_browser_info();
        $browser = $ua['name'];
        
        $page_id = WHTP_Hits::get_page_id( $page );
        /*
        * first check if the IP is in database
        * if the ip is not in the database, add it in
        * otherwise update
        */
        
        $ip_check  =  $wpdb->get_var( "SELECT ip_address FROM `{self::$hitinfo_table}` WHERE ip_address = '$ip_address'" );

        if ( $ip_check == ""){
            $insert_hit_info = $wpdb->insert(
                self::$hitinfo_table, 
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
            $ip_total_visits = $wpdb->get_var("SELECT ip_total_visits FROM `{self::$hitinfo_table}` WHERE ip_address = '$ip_address'");

            $ip_total_visits += 1;
            $update_ip_visit = $wpdb->update(
                self::$hitinfo_table, 
                array(
                    "ip_total_visits"       => $ip_total_visits, 
                    "user_agent"            => $browser, 
                    "datetime_last_visit"   => $date_ltime
                ),
                array("ip_address"=>$ip_address), 
                array("%d","%s","%s")
            );
        }
        
            
        $ua_id      = WHTP_Broswer::get_agent_id( $browser );
        $ip_id      = WHTP_Hit_Info::get_ip_id( $ip_address );
        $page_id    = WHTP_Hit::get_page_id ( $page );
        
        if ( !  WHTP_Broswer::browser_exists( $browser ) ){
            WHTP_Broswer::add_browser( $browser );
        }
        WHTP_Ip_Hits::ip_hit( $ip_id, $page_id, $date_ftime, $ua_id ); //insert new hit

        // get the country code corresponding to the visitor's IP
        $country_code   = WHTP_Visiting_Countries::get_country_code( $ip_address );
        $counted        = WHTP_Visiting_Countries::country_count( $country_code );
    }
}