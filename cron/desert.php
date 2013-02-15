<?php
define('MY_CRON_JOB_START', true);
require_once '../index.php';
$application->bootstrap();
ini_set('memory_limit', '-1');
$desert_action = new Application_Model_Desert_XMLWork();
$cron_work = new Application_Model_CronDBWork();
echo "<pre>";

// print_r($cron_work->My_test());exit;

 //$all_info = $desert_action->My_Desert_get_all_info();

 //print_r($all_info);
 //exit;

  /*$cities_array = $desert_action->My_Desert_get_cities(); 
  if($cities_array!=false) 
  { 
      print_r($cities_array);exit;
  //$cron_work->My_insert_desert_cities($cities_array); 
  }*/ 
 /* $services_array =  $desert_action->My_Desert_get_services(); 
  if ($services_array!=false) 
  {
  //$cron_work->My_insert_desert_services($services_array); 
  }*/
 

$suppliers_array = $desert_action->My_Desert_get_all_info();
if ($suppliers_array != false)
{
    // print_r($suppliers_array);exit;
    $cron_work->My_insert_desert_suppliers($suppliers_array);
    // $cron_work->My_insert_desert_cities_suppl_kaper($suppliers_array);
}

//$city_and_supplier_kaper = $cron_work->My_select_all_desert_cites_and_suppliers();
//print_r($city_and_supplier_kaper); exit;
/*if (!empty($city_and_supplier_kaper))
{
	$city_and_supplier_kaper_result = $desert_action->My_Desert_get_city_supplier($city_and_supplier_kaper);
	//$cron_work->My_insert_desert_cities_suppl_kaper($city_and_supplier_kaper);
}*/