<?php

define('MY_CRON_JOB_START', true);
require_once '../index.php';
$application->bootstrap();

$Serhs_action = new Application_Model_Serhs_XMLStaticData();
$cron_work = new Application_Model_CronDBWork();


$logger = Zend_Registry::get('logger');
 //echo"<pre>";
//print_r($Serhs_action->My_get_accommodations('ITA'));exit;
try
{
    
    $Serhs_countries = $Serhs_action->My_get_countries();
    
    if (!is_string($Serhs_countries))
    {
        $My_responce = $cron_work->My_insert_serhs_countrys($Serhs_countries);
        if ($My_responce != true)
        {
            $logger->err(
                    'Serhs Tourism cronjob country insert : ' . $My_responce);
           // exit();
        }
    }
    else
    {
        $logger->err(
                'Serhs Tourism cronjob countries not get : ' . $Serhs_countries);
       // exit();
    }
    
    $count_country = sizeof($Serhs_countries);
    $i = 0;
    while ($i < $count_country)
  //  foreach ($Serhs_countries as $country)
    {
        $country_code = $Serhs_countries[$i]['@attributes']['code'];
        
        $all_cities = $Serhs_action->My_get_cities($country_code);
        // print_r($all_cities);exit;
        if (!is_string($all_cities))
        {
            
            $My_insert_city_responce = $cron_work->My_insert_sehs_citys(
                    $all_cities, $country_code);
            
            if ($My_insert_city_responce != true)
            {
                $logger->err(
                        'Serhs Tourism cronjob cities insert : ' .
                                 $My_insert_city_responce);
              //  exit();
            }
        }
        else
        {
            $logger->err(
                    "Serhs Tourism cities not get width {$country_code} : " .
                             $all_cities);
         //   exit();
        }
        $i++;
    }
    // stop
    $i = 0;
    $count_country = sizeof($Serhs_countries);
    while ($i < $count_country)
    //foreach ($Serhs_countries as $country)
    {
        $country_code_accom = $Serhs_countries[$i]['@attributes']['code'];
        
        $Accomodations = $Serhs_action->My_get_accommodations($country_code_accom);
        /*while (true)
        {
            if (!is_string())
            {
                break;
            }
            else
            {
                sleep(60);
            }
        }*/
        
        if (!is_string($Accomodations))
        {
            
                $My_insert_accomodation = $cron_work->My_insert_serhs_accomodations(
                        $Accomodations, $country_code_accom);
                
                if ($My_insert_accomodation != true)
                {
                    $logger->err(
                            'Serhs Tourism cronjob Accomodations insert error : ' .
                                     $My_insert_accomodation);
                  //  exit();
                }
        }
        else
        {
            $logger->err(
                    "Serhs Tourism Accomodations not get width {$country_code_accom} : " .
                             $Accomodations);
            //exit();
        }
        $i++;
    }
}
catch (Exception $e)
{
    $logger->err(
            'Serhs Tourism ALL cronjob ERROR_ : ' . $e->getMessage());
    //exit();
}
