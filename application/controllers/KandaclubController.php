<?php

class KandaclubController extends Zend_Controller_Action
{

    private $My_front_DB;

    private $My_front_form;
    
    private $My_users_DB;
    
    private $My_cache;

    public function init ()
    {
        /* Initialize action controller here */
       // Zend_Layout::getMvcInstance()->assign('menu', 'foo');
    	if (!Zend_Session::namespaceIsset('Zend_User_Login'))
    	{
    		$action = $this->getRequest()->getActionName();
    		if($action != 'registration')
    		{
    			$this->_forward('login');
    		}
    		else
    		{
    			$this->_forward('registration');
    		}
    	}
    	
    	
    	
        $this->My_front_DB = new Application_Model_FrontDBWork();
        $this->My_front_form = new Application_Form_FrontForms();
        $this->My_users_DB = new Application_Model_UsersDBWork();
        $this->My_cache = new MyLib_Cache(); 
    }

    public function loginAction ()
    {
        if (Zend_Session::namespaceIsset('Zend_User_Login'))
        {
            $this->getResponse()->setRedirect($this->view->url(array('action'=>'home'),'my_default_route',true));
        }
        
   /*     $replase = str_replace('.', '', '50,39');
        $replase = str_replace(',', '.', $replase);
        $k = floatval($replase);
        echo $k."<br>";*/
       
        
        $this->_helper->_layout->setLayout('login_reg');
       //  $this->_helper->layout()->disableLayout();
      //   $this->_helper->viewRenderer->setNoRender(true);
        // action body
        // $Desert = new Application_Model_Desert_XMLWork();
         //$Serhs = new Application_Model_Serhs_XMLStaticData();
         $Serhs2 = new Application_Model_Serhs_XMLWork();
        
        $login_form = $this->My_front_form->My_login_form();
        $this->view->login_form = $login_form;
        if ($this->getRequest()->isPost())
        {
            $post = $this->getRequest()->getPost();
            if ($login_form->isValid($post))
            {
               $result = $login_form->getValues();
               

               $login_status = $this->My_users_DB->login($result['username'], $result['password']);
               
               
               if($login_status === true)
               {
                  $this->getResponse()->setRedirect($this->view->url(array('action'=>'home'),'my_default_route',true));
               }
               else
               {
                   $this->view->response_message =  $login_status;
               }
            }
            else
            {
            	$errors = $login_form->getErrors();
            	$errorsMessages = $login_form->getMessages();
            
            	$this->view->errors = $errors;
            	$this->view->errorsMessages = $errorsMessages;
            }
        }
        
        if ($this->_getParam('test') == "t")
        { 
            // $Serhs->My_get_countries();
            //$Serhs->My_get_accommodations();
            $Serhs2->My_accommodation_avail();
            
            //$Desert->My_Desert_Adventures_xml(); // $Desert->My_desert_test();

         //   $pdf = new Application_Model_PDFWork();
        }
    }

    public function registrationAction ()
    {
    	if (Zend_Session::namespaceIsset('Zend_User_Login'))
    	{
    		$this->getResponse()->setRedirect($this->view->url(array('action'=>'home'),'my_default_route',true));
    	}
    	echo "Registration";
        $this->_helper->_layout->setLayout('login_reg');
    }
    
    public function edituserinfoAction()
    {
        if (!Zend_Session::namespaceIsset('Zend_User_Login'))
        {
        	$this->getResponse()->setRedirect($this->view->url(array('action'=>'home'),'my_default_route',true));
        }
        $this->view->headTitle('Edit user info');
        echo "Edit user page";
    }

    public function homeAction ()
    {
       /* if (!Zend_Session::namespaceIsset('Zend_Auth'))
        {
            $this->getResponse()->setRedirect($this->view->url(array('action'=>'login'),'my_default_route',true));
        }
        else
        {
            $auth_info = Zend_Session::namespaceGet('Zend_Auth');
            $user_info_array = (array)$auth_info['storage'];
            
            Zend_Layout::getMvcInstance()->assign('username',$user_info_array['username']);
        }*/
               
       // echo '<pre>';

      //  $al_countrys = $this->My_front_DB->My_get_all_countrys();
       // $all_citys = $this->My_front_DB->My_get_all_cities();
        //$all_hotels = $this->My_front_DB->My_get_all_hotels();
       
        
        $search_form = $this->My_front_form->My_search_form();
        
        $this->view->search_form = $search_form;
        
        if ($this->getRequest()->isPost())
        {
            
            $post = $this->getRequest()->getPost();
            
            if ($search_form->isValid($post))
            {
                $form_submit = $search_form->getValues();
               
                $search_options = new Zend_Session_Namespace('Search_options');
                $search_options->__set('search_options', $form_submit);
                
                $this->My_front_DB->My_set_search_result_db($form_submit);
               
                
                // $this->render('searchresul');
                // echo Zend_Registry::get('test_reg');
                /*
                 * $this->_forward('searchresult', null, null, array( 'as' =>
                 * array( 'asd' => 'asdasd', 'er' => 'asdad' ) ));
                 */
                // $this->getResponse()->setRedirect($this->view->url(array('action'=>'searchresult'),'my_default_route',true));
            }
            else 
            {
            	$errors = $search_form->getErrors();
            	$errorsMessages = $search_form->getMessages();
            	 
            	$this->view->errors = $errors;
            	$this->view->errorsMessages = $errorsMessages;
            }
        }
        
        // $this->getResponse()->setRedirect($this->view->url(array('action'=>'login'),'my_login_route',true));
    }

    public function searchresultAction ()
    {
    	
    	if(Zend_Session::namespaceIsset('Search_options'))
    	{
    		$search_options = Zend_Session::namespaceGet('Search_options');
    		echo '<pre>';
    		print_r($search_options['search_options']);
       
          //  $post_data = $this->getRequest()->getPost();
          //  $booking_form_rend = '<ul>';
           /* for ($i = 0; $i < 5; $i ++)
            {
                $booking_form_rend .= "<li>";
                $booking_form = $this->My_front_form->My_add_booking();
                $booking_form_rend .= $booking_form;
                $booking_form_rend .= "</li>";
            }
            $booking_form_rend .= "</ul>";
            */
            //$this->view->booking_form = $booking_form_rend;
            
         /*   if ($booking_form->isValid($post_data))
            {
                echo "booking ok";
            }*/
        
    	}
    	else 
    	{
    		$this->getResponse()->setRedirect($this->view->url(array('action'=>'home'),'my_default_route',true));
    	}
        // $this->_helper->viewRenderer->setNoRender(true);
        
        // $this->getResponse()->setRedirect($this->view->url(array('action'=>'home'),'my_default_route',true));
    }

    public function testAction ()
    {
        // $this->_helper->viewRenderer->setNoRender(true);
        $lang = 'en';
        $array = include APPLICATION_PATH . "/languages/{$lang}.php";
        $form = $this->My_front_form->test_form($array, $lang);
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost())
        {
            $post = $this->getRequest()->getPost();
            
            if ($form->isValid($post))
            {
                $this->My_front_DB->test_write_file($form->getValues(), $array);
            }
        }
        
        // echo '<pre>';
        // print_r( $array );
    }
    public function logoutAction()
    {
         $this->_helper->layout()->disableLayout();
         $this->_helper->viewRenderer->setNoRender(true);
         
         $auth = Zend_Auth::getInstance();
         $auth->clearIdentity();
         Zend_Session::destroy(true);
         $sessions_list = glob(MY_SESSION_DIRECTORY . "/sess_*");
         foreach ($sessions_list as $ses)
         {
             if ( 0 == filesize( $ses ) )
             {
                 chmod($ses, 0777);
                 unlink($ses);
             }
         }
         
         $this->getResponse()->setRedirect($this->view->url(array('action'=>'login'),'my_default_route',true));
    }
}

