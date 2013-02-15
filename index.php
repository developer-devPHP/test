<?php
set_time_limit(99999999);
ini_set('memory_limit', '1000M');

date_default_timezone_set('Asia/Yerevan');
// Define session save path
defined('MY_SESSION_DIRECTORY') ||
         define('MY_SESSION_DIRECTORY', 
                realpath(dirname(__FILE__) . '/data/sessions'));

// Define My cache directory
defined('MY_CACHE_DIRECTORY') ||
         define('MY_CACHE_DIRECTORY', 
                realpath(dirname(__FILE__) . '/data/cache'));

// Define path to application directory
defined('APPLICATION_PATH') ||
         define('APPLICATION_PATH', 
                realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV') ||
         define('APPLICATION_ENV', 
                (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development')); // development  // production
                                                                                                                       
// Ensure library/ is on include_path
set_include_path(
        implode(PATH_SEPARATOR, 
                array(
                        realpath(APPLICATION_PATH . '/../library'),
                        get_include_path()
                )));

/**
 * Zend autoloader
 */
/*
 * require_once 'Zend/Loader/Autoloader.php'; $autoloader =
 * Zend_Loader_Autoloader::getInstance();
 * $autoloader->registerNamespace('MyPDF_');
 */

/**
 * Zend_Application
 */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(APPLICATION_ENV, 
        APPLICATION_PATH . '/configs/application.ini');
if (! defined('MY_CRON_JOB_START'))
{
    $application->bootstrap()->run();
}