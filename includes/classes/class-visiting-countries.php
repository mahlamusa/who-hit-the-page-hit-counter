<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class WHTP_Visiting_Countries extends WHTP_Database{
    public function __construct(){
        parent::__construct();
    }

    public static function country_exists( $country_code ) {
        $code = $wpdb->get_var(
            "SELECT country_code FROM `{self::$visiting_countries_table}` 
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
        global $wpdb;
        $res = false;
        $code = $wpdb->get_var(
            "SELECT country_code 
            FROM `{self::$visiting_countries_table}` 
            WHERE country_code = '$country_code'"
        );
        
        if ( $code ) {	
            $count = $wpdb->get_var(
                "SELECT count FROM `{self::$visiting_countries_table}` 
                WHERE country_code='$country_code'"
            );
            $count +=1;

            $updated = $wpdb->update(
                self::$visiting_countries_table, 
                array( "count" => $count ), 
                array( "country_code" => $country_code ), 
                array("%d"), array("%s")
            );
        }
        else {	
            $inserted = $wpdb->insert( 
                self::$visiting_countries_table, 
                array(
                    "country_code" => $country_code, 
                    "count" => 1
                )
            );            
        }

        if ( $updated || $inserted )  return true;
        else return false;
    }

    public static function get_top_countries( $number = 15 ){
		global $wpdb;
		$select_countries = $wpdb->get_results(
            "SELECT * FROM `{self::$visiting_countries_table}` 
            ORDER BY count DESC 
            LIMIT '$number'"
        );

		if ( $select_countries ){
			$countries = array();
			$num_rows = count($select_countries);
			if ( $num_rows > $number ) $max_count = $number;
			else $max_count = $num_rows;
			
			for ( $count = 0; $count < $max_count; $count ++ ) {
				$row = $select_countries[ $count ];
				$countries[] = array(
                    'country_code' => $row->country_code, 
                    'country_name' => WHTP_IP_Location::get_country_name( $row->country_code ),
                    'count'=> $row->count 
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
		global $wpdb;
         $ips = WHTP_Functions::all_ips();
         
		 for ( $count = 0; $count < count ( $ips ); $count ++ ){				
			$country_code = WHTP_IP_Location::get_country_code( $ips[$count] );
			
			$exists = self::country_exists( $country_code );
			
			if ( $exists ) {
				if ( $exists == "" ) {
					$wpdb->query ( "INSERT INTO `{self::$visiting_countries_table}` (country_code, count) VALUES ('$country_code', 1)" );
				}
				else{
					$wpdb->query ( "UPDATE `{self::$visiting_countries_table}` SET count=count+1 WHERE country_code='$country_code'" );
				}
			}
		 }
	}
}