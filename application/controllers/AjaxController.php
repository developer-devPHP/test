<?php

class AjaxController extends Zend_Controller_Action
{

    private $My_front_DB;

    private $My_front_form;
    
    private $My_cache;

    public function init ()
    {
        if (! $this->getRequest()->isXmlHttpRequest())
        {
            $this->getResponse()->setRedirect($this->view->url(array('action'=>'home'),'my_default_route',true));
        }
        
        $this->_helper->layout()->disableLayout();
        $this->My_front_DB = new Application_Model_FrontDBWork();
        $this->My_front_form = new Application_Form_FrontForms();
        
        $this->My_cache = new MyLib_Cache();
    }
    public function getallcityshotelsAction()
    {
    //    $time_start = microtime(true);
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $q = strtolower($this->getRequest()->getParam('q'));
        if (!$q) return;
        
        /* TOP MENU CACHE START*/
        $search_cities = $this->My_cache->My_cache_set('My_all_search_cities');
        
        if ( $search_cities === true)
        {
            $search_cities_values = $this->My_cache->My_cache_set('My_all_search_cities', null , true , $this->My_front_DB->My_All_serach_citys() );
        }
        else
        {
            $search_cities_values = $search_cities;
        }
        /* TOP MENU CACHE END */
        
        $search_hotels = $this->My_cache->My_cache_set('My_all_search_hotels');
        
        if ( $search_hotels === true)
        {
            $search_hotels_values = $this->My_cache->My_cache_set('My_all_search_hotels', null , true , $this->My_front_DB->My_ALL_search_hotels() );
        }
        else
        {
            $search_hotels_values = $search_hotels;
        }
        
        //echo "<pre>";
      // print_r($search_hotels_values);exit;
        
        $all_result = array_merge($search_cities_values,$search_hotels_values);
        
        
       // print_r($all_result);exit;
         $i = 0;
         $count_array_result = count($all_result);
         while ($i < $count_array_result)
         {
             $hidden_element = '';
             $public_element = '';
             $gps_data = '';
             $gps_reserv = '';
             
	            
             
             if (array_key_exists('desert_supplier_name',$all_result[$i]))
             {
                 $hiden_array = array(
                         //'serhs'=>array('hotel'=>$all_result[$i]['serhs_accommodation_code']),
                         'desert'=>array('hotel'=>$all_result[$i]['desert_supplier_code'])
                 );
                 $gps_data = array(
                         /*'serhs'=>array(
                                 'acom_latitude'=>$all_result[$i]['serhs_accommodation_latitude'],
                                 'acom_longitude'=>$all_result[$i]['serhs_accommodation_longitude']
                         )*/
                 );
                 $gps_reserv = array(
                 		'acom_address'=> $all_result[$i]['desert_supplier_name']
                 );
                 
                 $hidden_element = Zend_Json::encode($hiden_array);
                 $gps_data = Zend_Json::encode($gps_data);
                 $gps_reserv = Zend_Json::encode($gps_reserv);
                 
                 $hot_name = '';
                 $city_name = '';
                 $country_name = '';
                 
                 if (!empty($all_result[$i]['desert_supplier_name']))
                 {
                 	$hot_name = $all_result[$i]['desert_supplier_name'];
                 }
                 elseif(!empty($all_result[$i]['serhs_accommodation_name']))
                 {
                    $hot_name = $all_result[$i]['serhs_accommodation_name'];
                 }
                  
                 if(!empty($all_result[$i]['desert_city_name']))
                 {
                 	$city_name = $all_result[$i]['desert_city_name'];
                 }
                 elseif(!empty($all_result[$i]['serhs_city_name']))
                 {
                 	$city_name = $all_result[$i]['serhs_city_name'];
                 }
                 if (!empty($all_result[$i]['desert_country_name']))
                 {
                 	$country_name = $all_result[$i]['desert_country_name'];
                 }
                 elseif(!empty($all_result[$i]['serhs_country_name']))
                 {
                  	$country_name = $all_result[$i]['serhs_country_name']; 
                 }
                  
                 $public_element = $hot_name.' / '.$city_name. ' / '. $country_name;
             }
             elseif (array_key_exists('desert_city_name',$all_result[$i]))
             {
                 $hiden_array = array(
                        // 'serhs'=>array('city'=>$all_result[$i]['serhs_city_code']),
                         'desert'=>array('city'=>$all_result[$i]['desert_city_code'])
                 );
                 $gps_data = array(
                         /*'serhs'=>array(
                                 'city_latitude'=>$all_result[$i]['serhs_city_latitude'],
                                 'city_longitude'=>$all_result[$i]['serhs_city_longitude']
                         )*/
             
                 );
                 $gps_reserv = array(
                 	 		'city_address'=> $all_result[$i]['desert_city_name']
                 );
                 
                 $city_name = '';
                 $country_name = '';
             
                 $hidden_element = Zend_Json::encode($hiden_array);
                 $gps_data = Zend_Json::encode($gps_data);
                 $gps_reserv = Zend_Json::encode($gps_reserv);
                 if(!empty($all_result[$i]['desert_city_name']))
                 {
                 	$city_name = $all_result[$i]['desert_city_name'];
                 }
                 elseif(!empty($all_result[$i]['serhs_city_name']))
                 {
                 	$city_name = $all_result[$i]['serhs_city_name'];
                 }
                 if (!empty($all_result[$i]['desert_country_name']))
                 {
                 	$country_name = $all_result[$i]['desert_country_name'];
                 }
                 elseif(!empty($all_result[$i]['serhs_country_name']))
                 {
                 	$country_name = $all_result[$i]['serhs_country_name'];
                 }
                                  
                 $public_element = $city_name.' / '.$country_name;
             }
             
             
             if (strpos(strtolower($public_element), $q) !== false)
             {
                 echo "{$public_element}|{$hidden_element}|{$gps_data}|{$gps_reserv} \n\r";
             }
             
             $i++;
         }
        
     //   $time_end = microtime(true);
   //     echo $time_end - $time_start;
    }
    //1.2827141284943  cache foreach
    // 40.118574142456  foreach
    
    //0.88238501548767 cache while
    //38.959980964661  while
    public function countryenterformAction ()
    {
        $al_countrys = $this->My_front_DB->My_get_all_countrys();
        // $all_citys = $this->My_front_DB->My_get_all_cities();
        // $all_hotels = $this->My_front_DB->My_get_all_hotels();
        
        // $search_form =
    // $this->My_front_form->My_search_form($al_countrys,$all_citys,$all_hotels);
        
        // $this->view->search_form = $search_form;
    }
}