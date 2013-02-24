<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	private $view_page;
    protected function _initDbRegistry()
    {
    	set_time_limit(99999999);
    	ini_set('memory_limit', '1000M');
    	date_default_timezone_set('Asia/Yerevan');
    	
        $this->bootstrap('multidb');
        $multidb = $this->getPluginResource('multidb');
        Zend_Registry::set('db_public', $multidb->getDb('public_user'));
        Zend_Registry::set('db_admin', $multidb->getDb('admin_user'));
    }
    
    protected function _initViewHelpers ()
    {
        $this->_bootstrap("layout");
        $layout = $this->getResource("layout");
        $this->view_page = $layout->getView();
        
        $this->view_page->headMeta()->appendHttpEquiv("Content-Type", 
                "text/html; charset=utf-8");
        $this->view_page->headMeta()->appendName('viewport','width=device-width, initial-scale=1.0');
        $this->view_page->headTitle("Kanda Travel Club");
        $this->view_page->headTitle()->setSeparator(" :: ");
    }

    protected function _initMyLibraries ()
    {
        Zend_Loader_Autoloader::getInstance()->registerNamespace('MyLib_');
       // Zend_Loader_Autoloader::getInstance()->registerNamespace('HTMLPurifier');
    }
    

    protected function _initSession ()
    {
        // $options = $this->getOptions();
        $sessionOptions = array(
                'save_path' => MY_SESSION_DIRECTORY,
                'use_only_cookies' => true,
                'remember_me_seconds' => 60//86400 //864000
        );
        Zend_Session::setOptions($sessionOptions);
        Zend_Session::start();
        $defaultNamespace = new Zend_Session_Namespace();
        
        if (!isset($defaultNamespace->initialized)) 
        {
        	Zend_Session::regenerateId();
        	$defaultNamespace->initialized = true;
        }
    }
    
    protected function _initLogger ()
    {
        $writer = new Zend_Log_Writer_Stream(
                APPLICATION_PATH . '/../data/log/error.log');
        $format = '%timestamp% %priorityName% (%priority%): %message%' . PHP_EOL;
        $formatter = new Zend_Log_Formatter_Simple($format);
        $writer->setFormatter($formatter);
        $logger = new Zend_Log($writer);
        $logger->setTimestampFormat("d-M-Y H:i:s");
        Zend_Registry::set('logger', $logger);
    }

   /* protected function _initSetMultilanguage ()
    {
        $config = new Zend_Config_Ini(
                APPLICATION_PATH . '/configs/application.ini', 'production');
        $params = $config->toArray();
        $locales = $params['locales'];
        $show_lang = 'en';
        
        $request = new Zend_Controller_Request_Http();
        $myCookie = $request->getCookie('locale');
        if (empty($myCookie))
        {
            setcookie('locale', $show_lang, time() + (1 * 365 * 24 * 60 * 60), 
                    '/');
        }
        else
        {
            foreach ($locales as $langarray)
            {
                if ($langarray === $myCookie)
                {
                    $show_lang = $myCookie;
                }
            }
        }
        
       
        Zend_Registry::set('Zend_Locale', $show_lang);
    }
*/
    /*
    protected function _initTranslate ()
    {
        // Get Locale
        $locale = Zend_Registry::get('Zend_Locale');
        
        // Set up and load the translations (there are my custom translations
        // for my app)
        $translate = new Zend_Translate(
                array(
                        'adapter' => 'array',
                        'content' => APPLICATION_PATH . '/languages/' . $locale .
                                 '.php',
                                'locale' => $locale
                ));
        
        // Set up ZF's translations for validation messages.
        $translate_msg = new Zend_Translate(
                array(
                        'adapter' => 'array',
                        'content' => APPLICATION_PATH . '/languages/' . $locale .
                                 '/Zend_Validate.php',
                                'locale' => $locale
                ));
        
        // Add translation of validation messages
        $translate->addTranslation($translate_msg);
        
        Zend_Form::setDefaultTranslator($translate);
        
        // Save it for later
        Zend_Registry::set('Zend_Translate', $translate);
    }
*/
    protected function _initMyRouting ()
    {
     //   $show_lang = Zend_Registry::get('Zend_Locale');
        
        $frontController = Zend_Controller_Front::getInstance();
        $router = $frontController->getRouter();
        $router->removeDefaultRoutes();
        
        $my_default_route = new Zend_Controller_Router_Route(
                ':action/:title/:page/*', 
                array(
                        'controller' => 'kandaclub',
                        'action' => 'home',
                        'title' => 'Home',
                        
                        'page' => '1'
                )
                , 
                array(
                        
                        'page' => '\d+'
                ));
        
       /* $my_login_route = new Zend_Controller_Router_Route(
                'login/:action/:title/*', 
                array(
                        'controller' => 'kandaclub',
                        'action' => 'login',
                        'title' => 'Login page'
                ), array()

                );*/
        
        $my_ajax_route = new Zend_Controller_Router_Route('ajax/:action/*', 
                array(
                        'controller' => 'ajax',
                        'action' => 'ankap'
                )
                , array(
                ));
        
        $router->addRoute('my_default_route', $my_default_route);
      //  $router->addRoute('my_login_route', $my_login_route);
        $router->addRoute('my_ajax_route', $my_ajax_route);
    }
}

