<?php

class Application_Model_CronDBWork extends Zend_Db_Table
{

    private $My_DB;

    public function __construct ()
    {
        $this->My_DB = $this->getDefaultAdapter();
    }

    public function My_test ()
    {
        $sql = "
				SELECT * FROM desert_hotels
				LEFT JOIN desert_cities ON(desert_cities.City_Name = desert_cities.City_Name)
				WHERE desert_cities.City_Name <> desert_hotels.city_name
				";
        
        return $this->My_DB->getConnection()
            ->query($sql)
            ->fetchAll();
    }

    public function My_insert_desert_cities ($cities_array)
    {
        $sql_empty_table = "DELETE FROM desert_cities WHERE 1";
        
        $this->My_DB->beginTransaction();
        try
        {
            $this->My_DB->getConnection()->query($sql_empty_table);
            
            foreach ($cities_array as $city)
            {
                if ($city['Name'] == "General")
                {
                    continue;
                    /*
                     * $city_name = $this->My_DB->quote("All"); $city_code =
                     * $this->My_DB->quote("???"); $sql_inser_city = "INSERT
                     * INTO desert_cities
                     * (city_name,city_shortcode,city_sorting) VALUES
                     * ({$city_name},{$city_code},'1')";
                     */
                }
                else
                {
                    $city_name = $this->My_DB->quote($city['Name']);
                    $city_code = $this->My_DB->quote($city['Code']);
                    $sql_inser_city = "INSERT INTO desert_cities (City_Name,City_Shortcode) VALUES ({$city_name},{$city_code})";
                }
                $this->My_DB->getConnection()->query($sql_inser_city);
            }
            
            $this->My_DB->commit();
            
            // print_r($cities_array);
        }
        catch (Exception $e)
        {
            $this->My_DB->rollBack();
            // echo $e->getMessage();exit;
        }
    }

    public function My_insert_desert_services ($services_array)
    {
        $sql_empty_table = "DELETE FROM desert_services WHERE 1";
        
        $this->My_DB->beginTransaction();
        
        try
        {
            $this->My_DB->getConnection()->query($sql_empty_table);
            
            foreach ($services_array as $service)
            {
                $service_name = $this->My_DB->quote($service['Name']);
                $service_code = $this->My_DB->quote($service['Code']);
                
                $sql_insert_service = "INSERT INTO desert_services (service_name,service_shortcode) VALUES ({$service_name},{$service_code})";
                $this->My_DB->getConnection()->query($sql_insert_service);
            }
            
            $this->My_DB->commit();
        }
        catch (Exception $e)
        {
            $this->My_DB->rollBack();
            // echo $e->getMessage();exit;
        }
    }

    public function My_insert_desert_suppliers ($suppliers_array)
    {
        $sql_empty_table = "DELETE FROM desert_suppliers WHERE 1";
        
        $this->My_DB->beginTransaction();
        
        try
        {
            $this->My_DB->getConnection()->query($sql_empty_table);
            
            foreach ($suppliers_array->Option as $supplier)
            {

                $supplier_name = $this->My_DB->quote(
                        $supplier->OptGeneral->SupplierName);
                $supplier_code = $this->My_DB->quote(
                        mb_substr($supplier->Opt, 5, 6));
                $desert_city_code = $this->My_DB->quote(
                        mb_substr($supplier->Opt, 0, 3));
                
                if (! empty($supplier->OptGeneral->Address5))
                {
                    $country_name = explode(' ', 
                            str_replace('.', '', 
                                    $supplier->OptGeneral->Address5));
                    $country_name = $this->My_DB->quote($country_name[0]);
                }
                
                $desert_service_code = $this->My_DB->quote(
                        mb_substr($supplier->Opt, 3, 2));
                
                if (! empty($supplier->OptGeneral->ClassDescription))
                {
                    $hotel_star_name = $this->My_DB->quote(
                            $supplier->OptGeneral->ClassDescription);
                }
                
                // echo " {$supplier_name} {$supplier_code} {$desert_city_code}
                // {$country_name} {$desert_service_code} {$hotel_star_name}
                // </br> RAKACACA00103001 ";exit;
                
                $sql_if_not_exist = "SELECT count(*) FROM desert_suppliers WHERE Supplier_Code={$supplier_code}";
                
                $exist_status = $this->My_DB->getConnection()
                    ->query($sql_if_not_exist)
                    ->fetchColumn();
                
                if ($exist_status == 0)
                {
                    
                    $sql_insert_supplier = "
								INSERT INTO desert_suppliers (Supplier_Name,Supplier_Code,desert_city_code,country_name,desert_service_code,hotel_star_name) 
										VALUES ({$supplier_name},{$supplier_code},{$desert_city_code},{$country_name},{$desert_service_code},{$hotel_star_name})
								";
                    $this->My_DB->getConnection()->query($sql_insert_supplier);
                }
            }
            
            $this->My_DB->commit();
        }
        catch (Exception $e)
        {
            $this->My_DB->rollBack();
            echo $e->getMessage();
            exit();
        }
    }

    public function My_insert_serhs_countrys ($countries_array)
    {
        $sql_delete = 'DELETE FROM serhs_countries WHERE 1';
        
        $this->My_DB->beginTransaction();
        try
        {
            $this->My_DB->getConnection()->query($sql_delete);
            
            foreach ($countries_array as $country)
            {
                $country_name = $this->My_DB->quote(
                        $country['@attributes']['englishName']);
                $country_code = $this->My_DB->quote(
                        $country['@attributes']['code']);
                
                $sql_insert = "INSERT INTO serhs_countries 
    	                        (serhs_country_name , serhs_country_code)
    	                        VALUES
    	                        ({$country_name},{$country_code})";
                
                $this->My_DB->getConnection()->query($sql_insert);
            }
            
            $this->My_DB->commit();
            return true;
        }
        catch (Exception $e)
        {
            $this->My_DB->rollBack();
            return $e->getMessage();
        }
    }

    public function My_insert_sehs_citys ($citys_array, $country_code)
    {
        $sql_delete = "DELETE FROM serhs_cities WHERE serhs_country_code='{$country_code}'";
        $this->My_DB->beginTransaction();
        try
        {
            $this->My_DB->getConnection()->query($sql_delete);
            $country_code = $this->My_DB->quote($country_code);
            
            if (! isset($citys_array['cities']['city']))
            {
                $flag = false;
                foreach ($citys_array as $regions_array)
                {
                    if ($flag == true)
                    {
                        break;
                    }
                    foreach ($regions_array['cities']['city'] as $city)
                    {
                        if (! isset($city['@attributes']['code']))
                        {
                            $city = $regions_array['cities']['city'];
                            $flag = true;
                        }
                        
                        $city_code = $this->My_DB->quote(
                                $city['@attributes']['code']);
                        $city_name = $this->My_DB->quote(
                                $city['@attributes']['name']);
                        
                        if (isset($city['gpsCoordinates']) &&
                                 ! empty($city['gpsCoordinates']))
                        {
                            $gps_latitude = $this->My_DB->quote(
                                    $city['gpsCoordinates']['@attributes']['latitude']);
                            $gps_longitude = $this->My_DB->quote(
                                    $city['gpsCoordinates']['@attributes']['longitude']);
                            
                            $sql_insert = "
                                INSERT INTO serhs_cities 
                                    (serhs_country_code , serhs_city_code , serhs_city_name , serhs_city_latitude , serhs_city_longitude)
                                VALUES
                                    ({$country_code},{$city_code},{$city_name},{$gps_latitude},{$gps_longitude})
                                ";
                            
                            $this->My_DB->getConnection()->query($sql_insert);
                        }
                        else
                        {
                            $sql_insert = "
                        INSERT INTO serhs_cities
                        (serhs_country_code , serhs_city_code , serhs_city_name)
                        VALUES
                        ({$country_code},{$city_code},{$city_name})
                        ";
                            
                            $this->My_DB->getConnection()->query($sql_insert);
                        }
                        if ($flag == true)
                        {
                            break;
                        }
                    }
                }
            }
            else
            {
                $flag = false;
                foreach ($citys_array['cities']['city'] as $city)
                {
                    if ($flag == true)
                    {
                        break;
                    }
                    if (! isset($city['@attributes']['code']))
                    {
                        $city = $citys_array['cities']['city'];
                        $flag = true;
                    }
                    
                    $city_code = $this->My_DB->quote(
                            $city['@attributes']['code']);
                    $city_name = $this->My_DB->quote(
                            $city['@attributes']['name']);
                    
                    if (isset($city['gpsCoordinates']) &&
                             ! empty($city['gpsCoordinates']))
                    {
                        $gps_latitude = $this->My_DB->quote(
                                $city['gpsCoordinates']['@attributes']['latitude']);
                        $gps_longitude = $this->My_DB->quote(
                                $city['gpsCoordinates']['@attributes']['longitude']);
                        
                        $sql_insert = "
                        INSERT INTO serhs_cities
                        (serhs_country_code,serhs_city_code,serhs_city_name,serhs_city_latitude,serhs_city_longitude)
                        VALUES
                        ({$country_code},{$city_code},{$city_name},{$gps_latitude},{$gps_longitude})
                        ";
                        
                        $this->My_DB->getConnection()->query($sql_insert);
                    }
                    else
                    {
                        $sql_insert = "
                            INSERT INTO serhs_cities
                        (serhs_country_code,serhs_city_code,serhs_city_name)
                        VALUES
                        ({$country_code},{$city_code},{$city_name})
                        ";
                        
                        $this->My_DB->getConnection()->query($sql_insert);
                    }
                }
            }
            $this->My_DB->commit();
            return true;
        }
        catch (Exception $e)
        {
            $this->My_DB->rollBack();
            return $e->getMessage();
        }
    }

    public function My_insert_serhs_accomodations ($accomodations_array, 
            $country_code)
    {
        $sql_delete = "DELETE FROM serhs_accommodations WHERE serhs_country_code = '{$country_code}'";
        $this->My_DB->beginTransaction();
        
        try
        {
            $flag = false;
            $this->My_DB->getConnection()->query($sql_delete);
            $country_code = $this->My_DB->quote($country_code);
            
            foreach ($accomodations_array as $accomodation)
            {
                if (!isset($accomodation['city']))
                {
                    $accomodation = $accomodations_array;
                    $flag = true;
                }
                $serhs_city_code = $this->My_DB->quote( $accomodation['city']['@attributes']['code'] );
                $serhs_accommodation_code = $this->My_DB->quote( $accomodation['@attributes']['code'] );
                $serhs_accommodation_name = $this->My_DB->quote( $accomodation['@attributes']['name'] );
                
                $serhs_accommodation_address = 'NULL';
                if (isset($accomodation['address'] ) && !empty($accomodation['address']) )
                {
                  $serhs_accommodation_address = $this->My_DB->quote( $accomodation['address'] );
                }
                
                $serhs_accommodation_phone = 'NULL';
                $serhs_accommodation_fax = 'NULL';
                
                if (isset($accomodation['phones']))
                {
                    if (isset($accomodation['phones']['phone'][0]['@attributes']['number']))
                    {
                        $serhs_accommodation_phone = $this->My_DB->quote( $accomodation['phones']['phone'][0]['@attributes']['number'] );
                    }
                    
                    if (isset($accomodation['phones']['phone'][1]['@attributes']['number']))
                    {
                        $serhs_accommodation_fax = $this->My_DB->quote( $accomodation['phones']['phone'][1]['@attributes']['number'] );
                    }
                    
                }
                
                $serhs_accommodation_latitude = 'NULL';
                $serhs_accommodation_longitude = 'NULL';
                
                if (isset($accomodation['gpsCoordinates']))
                {
                    $latitude = (float) $accomodation['gpsCoordinates']['@attributes']['latitude'];
                    $longitude = (float) $accomodation['gpsCoordinates']['@attributes']['longitude'];
                    if (!empty($latitude) && !empty($longitude))
                    {
                        $serhs_accommodation_latitude = $this->My_DB->quote( $accomodation['gpsCoordinates']['@attributes']['latitude'] );
                        $serhs_accommodation_longitude = $this->My_DB->quote( $accomodation['gpsCoordinates']['@attributes']['longitude'] );
                    }
                }
                
                $serhs_accommodation_description = 'NULL';
                
                if (isset($accomodation['description']) && !is_array($accomodation['description']))
                {
                    $serhs_accommodation_description = $this->My_DB->quote( $accomodation['description'] );
                }
                
                $serhs_accommodation_remarks = 'NULL';
                
                if (isset($accomodation['remarks']) && !is_array($accomodation['remarks']))
                {
                   $serhs_accommodation_remarks = $this->My_DB->quote( $accomodation['remarks'] );
                }
                
                $serhs_accommodation_star = $this->My_DB->quote( $accomodation['category']['@attributes']['code'] );
                $serhs_accommodation_star_name = $this->My_DB->quote( $accomodation['category']['@attributes']['name'] );
                
                $sql_insert_accommodation = "INSERT INTO serhs_accommodations
                        (serhs_country_code , serhs_city_code , serhs_accommodation_code ,
                        serhs_accommodation_name , serhs_accommodation_address , 
                        serhs_accommodation_star , serhs_accommodation_star_name ,
                        serhs_accommodation_phone , serhs_accommodation_fax ,
                        serhs_accommodation_latitude , serhs_accommodation_longitude ,
                        serhs_accommodation_description , serhs_accommodation_remarks
                        )
                        VALUES
                        ({$country_code} , {$serhs_city_code} , {$serhs_accommodation_code} ,
                        {$serhs_accommodation_name} , {$serhs_accommodation_address} ,
                        {$serhs_accommodation_star} , {$serhs_accommodation_star_name} ,
                        {$serhs_accommodation_phone} , {$serhs_accommodation_fax} ,
                        {$serhs_accommodation_latitude} , {$serhs_accommodation_longitude} ,
                        {$serhs_accommodation_description}, {$serhs_accommodation_remarks}
                        )
                ";
                $this->My_DB->getConnection()->query($sql_insert_accommodation);
             
                if($flag == true)
                {
                    break;
                }
            }
            $this->My_DB->commit();
            return true;
        }
        catch (Exception $e)
        {
            $this->My_DB->rollBack();
           // exit($e->getMessage()."<br/>".$country_code." ".$serhs_accommodation_code);
            return $e->getMessage();
        }
    }
}