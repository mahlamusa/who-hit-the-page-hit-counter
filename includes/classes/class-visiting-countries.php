<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_Visiting_Countries{
    private static $visiting_countries_table;

    public function __construct(){
        global $wpdb;
        
        self::$visiting_countries_table = $wpdb->prefix . 'whtp_visiting_countries';
    }

    public static function country_exists( $country_code ) {
        global $wpdb, $visiting_countries_table;

        $code = $wpdb->get_var(
            "SELECT country_code FROM `$visiting_countries_table` 
            WHERE country_code = '$country_code'" 
        );

        if ( $code ) return true;
        else return false;
    }

    /*
    * Count a visiting country
    * update country's count
    */
    public static function country_count( $country_code ){	
        global $wpdb, $visiting_countries_table;

        $res = false;
        $code = $wpdb->get_var(
            "SELECT country_code 
            FROM `$visiting_countries_table` 
            WHERE country_code = '$country_code'"
        );
        
        if ( $code ) {	
            /**$count = $wpdb->get_var(
                "SELECT count_hits FROM `$visiting_countries_table` 
                WHERE country_code='$country_code'"
            );
            $count +=1;**/

            $updated = $wpdb->update(
                $visiting_countries_table, 
                array( "count_hits" => "count_hits + 1" ), 
                array( "country_code" => $country_code ), 
                array("%d"), array("%s")
            );
        }
        else {	
            $inserted = $wpdb->insert( 
                $visiting_countries_table, 
                array(
                    "country_code" => $country_code, 
                    "count_hits" => 1
                )
            );            
        }

        if ( isset( $updated ) && $updated || isset( $inserted ) && $inserted )  return true;
        else return false;
    }

    public static function get_top_countries( $number = 15 ){
        global $wpdb, $visiting_countries_table;
        
		$select_countries = $wpdb->get_results(
            "SELECT * FROM `$visiting_countries_table` 
            ORDER BY count_hits DESC 
            LIMIT $number"
        );

		if ( $select_countries ){
			$countries = array();
			$num_rows = count( $select_countries );
			if ( $num_rows > $number ) $max_count = $number;
            else $max_count = $num_rows;
            
            $number = count( $select_countries ) <= $number ? count( $select_countries ) : $number;
			
			for ( $i = 0; $i < $number; $i ++ ) {
				$row = $select_countries[ $i ];
				$countries[] = array(
                    'country_code' => $row->country_code, 
                    'country_name' => WHTP_IP2_Location::get_country_name( $row->country_code ),
                    'count_hits'=> $row->count_hits
                );
            }
            
			return $countries;
		}		
    }
    
    
    
    /*
	* get all IP addresses previously registered
	* get country_code for each ip and
	* add the country to the list of visiting countries
	*/ 
	public static function update_visiting_countries(){
        global $wpdb, $visiting_countries_table;
        
        $ips = WHTP_Functions::all_ips();
        
        for ( $i = 0; $i < count ( $ips ); $i ++ ){				
            $country_code = WHTP_IP2_Location::get_country_code( $ips[$i] );
            
            $exists = self::country_exists( $country_code );
            
            if ( $exists ) {
                if ( $exists == "" ) {
                    $wpdb->query ( "INSERT INTO `$visiting_countries_table` ('country_code', 'count_hits') VALUES ('$country_code', 1)" );
                }
                else{
                    $wpdb->query ( "UPDATE `$visiting_countries_table` SET count_hits=count_hits+1 WHERE country_code='$country_code'" );
                }
            }
        }

        update_option( 'whtp_vc_updated', "yes");
	}
}