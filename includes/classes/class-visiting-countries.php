<?php

class WHTP_Visiting_Countries extends WHTP_Database{
    public function __construct(){
        parent::__construct();
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
                    'country_code' =>$row->country_code, 
                    'country_name' => self::get_country_name($row->country_code),
                    'count'=> $row->count 
                );
            }
            
			return $countries;
		}		
    }
    
    public static function get_country_name( $country_code ){
		global $wpdb;
		$country_name = $wpdb->get_var("SELECT country_name FROM whtp_ip2location WHERE country_code='$country_code' LIMIT 0,1");
		if ( $country_name == "") return "Unknown Country";
		else return $country_name;
	}
}