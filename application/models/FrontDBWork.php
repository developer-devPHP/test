<?php

class Application_Model_FrontDBWork
{

    private $My_DB;
    private $My_Desert;
    private $My_cache;

    public function __construct ()
    {
        $this->My_DB = Zend_Db_Table::getDefaultAdapter();
        $this->My_Desert = new Application_Model_Desert_XMLWork();
        $this->My_cache = new MyLib_Cache();
    }

    public function test_write_file ($new_array, $old_array)
    {
        $lang_l = $new_array['language'];
        
        $result_header = '<?php 
                $MyLanguage = array (
        ';
        $result_footer = ');
 
         return $MyLanguage;';
        $result_body = '';
        
        $filter = new Zend_Filter_Alnum();
        foreach ($old_array as $key => $old)
        {
            $old = $filter->filter($old);
            $old = str_replace('"',"'",$new_array[$old]);
            $old = str_replace('$', '\$', $old);
            
            $result_body .= '"' . $key . '" => "' .$old. '", ';
        }
        
        $return_file = $result_header . $result_body . $result_footer;
        
        $fp = fopen(APPLICATION_PATH . '/languages/' . $lang_l . '.php', "w");
        
        fwrite($fp, $return_file);
        
        fclose($fp);
    }

    public function My_get_all_countrys ()
    {
        $sql = "SELECT country_name FROM desert_suppliers
				GROUP BY country_name
				ORDER BY country_name";
        $result = $this->My_DB->getConnection()
            ->query($sql)
            ->fetchAll();
        return $result;
    }

    public function My_get_all_cities ()
    {
        $sql = "SELECT * FROM desert_cities
				ORDER BY City_Name ASC";
        $result = $this->My_DB->getConnection()
            ->query($sql)
            ->fetchAll();
        
        return $result;
    }

    public function My_get_all_hotels ()
    {
        $sql = "SELECT * FROM desert_suppliers";
        
        $result = $this->My_DB->getConnection()
            ->query($sql)
            ->fetchAll();
        
        return $result;
    }
    
    public function My_All_serach_citys()
    {
        
        $sql = "
                SELECT *
                FROM serhs_countries S_country
                INNER JOIN serhs_cities AS S_city ON (S_city.serhs_country_code = S_country.serhs_country_code)
                LEFT OUTER JOIN desert_cities AS D_city ON (D_city.City_Name = S_city.serhs_city_name)
                
                ORDER BY S_city.serhs_city_name ASC
            
                
                ";
        /*
         *   LEFT JOIN desert_cities AS D_city ON (D_city.City_Name = D_city.City_Name)
         *   
         *  INNER JOIN serhs_cities AS S_city ON (S_city.serhs_country_code = S_country.serhs_country_code)
                INNER JOIN serhs_accommodations AS S_accomod ON (S_accomod.serhs_country_code = S_country.serhs_country_code  AND S_accomod.serhs_city_code = S_city.serhs_city_code )
         * 
         * */
        $result = $this->My_DB->getConnection()
        ->query($sql)
        ->fetchAll();
        
        return $result;
    }
    public function My_ALL_search_hotels()
    {
        /*
         * 
         * S_accom.serhs_accommodation_code , S_accom.serhs_accommodation_name, S_city.serhs_city_name , S_country.serhs_country_name,
                        S_accom.serhs_accommodation_latitude, S_accom.serhs_accommodation_longitude
         * 
         * */
        $sql = "
                
                SELECT *
                FROM serhs_countries S_country
                INNER JOIN serhs_cities AS S_city ON (S_city.serhs_country_code = S_country.serhs_country_code)
                LEFT OUTER JOIN desert_cities AS D_city ON (D_city.City_Name = S_city.serhs_city_name)
                
                INNER JOIN serhs_accommodations AS S_accom ON (S_accom.serhs_country_code = S_country.serhs_country_code  AND S_accom.serhs_city_code = S_city.serhs_city_code )
                LEFT OUTER JOIN desert_suppliers AS D_suppl ON(D_suppl.Supplier_Name = S_accom.serhs_accommodation_name AND D_suppl.desert_city_code = D_city.City_Shortcode )
        		INNER JOIN desert_cities AS D_city_n ON(D_city_n.City_Shortcode = D_suppl.desert_city_code)	
                
                UNION ALL
                
                SELECT *
                FROM serhs_countries S_country
                INNER JOIN serhs_cities AS S_city ON (S_city.serhs_country_code = S_country.serhs_country_code)
                RIGHT OUTER JOIN desert_cities AS D_city ON (D_city.City_Name = S_city.serhs_city_name)
                
                INNER JOIN serhs_accommodations AS S_accom ON (S_accom.serhs_country_code = S_country.serhs_country_code  AND S_accom.serhs_city_code = S_city.serhs_city_code )
                RIGHT OUTER JOIN desert_suppliers AS D_suppl ON(D_suppl.Supplier_Name = S_accom.serhs_accommodation_name AND D_suppl.desert_city_code = D_city.City_Shortcode )
        		INNER JOIN desert_cities AS D_city_n ON (D_city_n.City_Shortcode = D_suppl.desert_city_code)
               
                ORDER BY if(serhs_accommodation_name = '' or serhs_accommodation_name is null,1,0),serhs_accommodation_name
                
               
                
                "; ///  ORDER BY S_accom.serhs_accommodation_name ASC
        
        $result = $this->My_DB->getConnection()
        ->query($sql)
        ->fetchAll();
        
        return $result;
    }
    
    public function My_set_search_result_db($form_submit_values)
    {
        $check_in_date = $form_submit_values['check_in_date'];
        $check_out_date = $form_submit_values['check_out_date'];
        
        $today = date('d-Y',time());

        //$search_cache = $this->My_cache->My_cache_set($cache_name);
        
    	$desert = $this->My_Desert->My_Desert_get_search_info($form_submit_values);
    	
    	echo '<pre>';
    	print_r($desert);
    }
    
}