<?php

class Application_Form_FrontForms
{

    private $My_form_decorator;

    private $My_standart_decorator;

    private $My_standart_decorator_without_lable;

    private $My_button_decorators;

    private $My_files_decorators;

    private $My_front_URL_helper;

    private $My_captcha_decorators;

    public function __construct ()
    {
        $this->My_front_URL_helper = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'url');
        
        $this->My_form_decorator = array(
                'FormElements',
                array(
                        'HtmlTag',
                        array(
                                'tag' => 'table'
                        )
                ),
                'Form'
        );
      
        $this->My_standart_decorator = array(
                'ViewHelper',
				array(
                        array(
                                'data' => 'HtmlTag'
                        ),
                        array(
                                'tag' => 'div',
                        		'class'=>'controls'
                        )
                ),
                array(
                        'Label',
                        array(
                                'class' => 'control-label'
                        )
                ),
                array(
                        array(
                                'row' => 'HtmlTag'
                        ),
                        array(
                                'tag' => 'div',
                        		'class'=>'control-group'
                        )
                )
        );
        
        $this->My_standart_decorator_without_lable = array(
                'ViewHelper',
				/*'Errors',*/
				array(
                        array(
                                'data' => 'HtmlTag'
                        ),
                        array(
                                'tag' => 'td'
                        )
                ),
                
                array(
                        array(
                                'row' => 'HtmlTag'
                        ),
                        array(
                                'tag' => 'tr'
                        )
                )
        );
        
        $this->My_button_decorators = array(
                'ViewHelper',
                array(
                        array(
                                'data' => 'HtmlTag'
                        ),
                        array(
                                'tag' => 'div',
                        		'class'=> 'controls'
                        )
                )
     
        );
        $this->My_files_decorators = array(
                'File',
                array(
                        array(
                                'Value' => 'HtmlTag'
                        ),
                        array(
                                'tag' => 'td'
                        )
                ),
				/*'Errors',*/
				'Description',
                array(
                        'Label',
                        array(
                                'tag' => 'td'
                        )
                ),
                array(
                        array(
                                'Field' => 'HtmlTag'
                        ),
                        array(
                                'tag' => 'tr'
                        )
                )
        );
        
        $this->My_captcha_decorators = array(
                
                array(
                        array(
                                'data' => 'HtmlTag'
                        ),
                        array(
                                'tag' => 'td'
                        )
                ),
                array(
                        'Label',
                        array(
                                'tag' => 'td'
                        )
                ),
                array(
                        array(
                                'row' => 'HtmlTag'
                        ),
                        array(
                                'tag' => 'tr'
                        )
                )
        );
    }

    public function My_login_form ()
    {
        $form = new Zend_Form();
        $form->setName("login_form")
            ->setDecorators($this->My_form_decorator)
            ->setMethod('post')
            ->setAttrib('enctype', 'multipart/form-data');
        
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username')
            ->setRequired(true)
            ->setAttrib('class','span3')
            ->setDecorators($this->My_standart_decorator);
        
        $form->addElement($username, 'username');
        
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
            ->setRequired(true)
            ->setAttrib('class','span3')
            ->setDecorators($this->My_standart_decorator);
        
        $form->addElement($password, 'password');
        
        $remember_me = new Zend_Form_Element_Checkbox('remember_me');
        $remember_me
            ->setLabel('Remember me (15 days)')
            ->setDecorators($this->My_standart_decorator);
        
        $form->addElement($remember_me,'remember_me');
        
        $privateKey = '6LfbpMgSAAAAAFUlA1_HAhctrWRXV9Avr9ErUP5x';
        $publicKey = '6LfbpMgSAAAAAEpzEHWa78x3MS3vt4z_rGjTx1z5';
        
        $recaptcha = new Zend_Service_ReCaptcha($publicKey, $privateKey);
        // create the captcha control
        $captcha = new Zend_Form_Element_Captcha('captcha', 
                array(
                        'captcha' => 'ReCaptcha',
                        'captchaOptions' => array(
                                'captcha' => 'ReCaptcha',
                                'service' => $recaptcha,
                                'theme' => 'white',
                                'width' => '300'
                        )
                ));
        
        $captcha->setLabel('Captcha')
            ->setRequired(true)
            ->setDecorators($this->My_captcha_decorators);
        
     //    $form->addElement($captcha,'captcha');
        
        $login = new Zend_Form_Element_Submit('login');
        $login
            ->setLabel('Login')
            ->setDescription("<a id='registration_btn' class='btn pull-left' href='{$this->My_front_URL_helper->url(array('action'=>'registration'),null,true)}'>Registration</a>")
            ->setAttrib('class','btn btn-inverse pull-left')
            ->setDecorators(
                array(
                        'ViewHelper',
                		array('Description', 
                			array(
                					'escape' => false, 
               						'tag' => false
                				)),
                ));
        
        $form->addElement($login, 'login');
        
        $registration = new Zend_Form_Element_Button('registration');
        $registration
            ->setLabel('Registration')
            ->setDecorators(  array(
                        'ViewHelper',
                ));
            
    //    $form->addElement($registration,'registration');
        
        return $form;
    }

    public function My_search_form ()
    {
        $form = new Zend_Form();
        $form->setName("base_search_form")
            ->setDecorators($this->My_form_decorator)
            ->setMethod('post')
            ->setAttrib('enctype', 'multipart/form-data');
        
        /*
         * $enter_contry = new Zend_Form_Element_Select('enter_country');
         * $enter_contry->setLabel('Enter a Country') ->setAttrib('disable',
         * 'disable') ->setDecorators($this->My_standart_decorator); foreach
         * ($all_countrys as $country) {
         * $enter_contry->addMultiOption($country['country_name'],
         * $country['country_name']); } $enter_contry->setValue('UAE');
         * $form->addElement($enter_contry, 'enter_country');
         */
        
        $enter_city = new Zend_Form_Element_Text('city_hotel_name');
        $enter_city
        	->setLabel('Enter City or Hotel')
            ->setRequired(true)
            ->setAttrib('class', 'span6')
            ->setDecorators($this->My_standart_decorator);
    /*    
        foreach ($all_citys as $city)
        {
            /*$enter_city->addMultiOption($city['City_Shortcode'], 
                    $city['City_Name']);*/
        /*    $enter_city->addMultiOption($city['serhs_city_code'],$city['serhs_city_name'].'&nbsp;&nbsp;/ '.$city['serhs_country_name']);
        }*/
        
      /*  foreach ($all_hotels as $hotel)
        {
            
            $enter_city->addMultiOption($hotel['serhs_accommodation_code'],$hotel['serhs_accommodation_name'].'&nbsp;&nbsp;/&nbsp;&nbsp; '.$hotel['serhs_city_name']. '&nbsp;&nbsp;/&nbsp;&nbsp;'. $hotel['serhs_country_name']);
        }*/
        
        $form->addElement($enter_city, 'city_hotel_name');
        
    /*    $search_by_hotel_name = new Zend_Form_Element_Select(
                'search_by_hotel_name');
        $search_by_hotel_name->setLabel('Search by Hotel Name')->setDecorators(
                $this->My_standart_decorator);
        
        foreach ($all_hotels as $hotel)
        {
           
          $search_by_hotel_name->addMultiOption($hotel['serhs_accommodation_code'],$hotel['serhs_accommodation_name'].'&nbsp;&nbsp; ; '.$hotel['serhs_city_name']. '&nbsp;&nbsp; ; '. $hotel['serhs_country_name']);
            
        }
        
        $form->addElement($search_by_hotel_name, 'search_by_hotel_name');
        */
        
        $check_in_date = new Zend_Form_Element_Text('check_in_date');
        $check_in_date->setLabel('Check In Date')
            ->setRequired(true)
            ->addValidator(
                new Zend_Validate_Date(
                        array(
                                "format" => 'yyyy-mm-dd'
                        )))
            ->setDecorators($this->My_standart_decorator);
        
        $form->addElement($check_in_date, 'check_in_date');
        
        $check_out_date = new Zend_Form_Element_Text('check_out_date');
        $check_out_date->setLabel('Check Out Date')
            ->setRequired(true)
            ->addValidator(
                new Zend_Validate_Date(
                        array(
                                "format" => 'yyyy-mm-dd'
                        )))
            ->setDecorators($this->My_standart_decorator);
        
        $form->addElement($check_out_date, 'check_out_date');
        
        $number_of_nights = new Zend_Form_Element_Select('number_of_nights');
        $number_of_nights->setLabel('Number Of Nights')
            ->setRequired(true)
            ->addMultiOption('0', 'Select Number Of Nights')
         //   ->setValue('')
            ->setDecorators($this->My_standart_decorator);
        for ($i = 1; $i <= 30; $i ++)
        {
            $number_of_nights->addMultiOption($i, $i);
        }
        
        $form->addElement($number_of_nights, 'number_of_nights');
        
       $select_rooms = new Zend_Form_Element_Select('select_rooms');
       $select_rooms
           ->setLabel('How many rooms do you require?')
           ->setRequired(true)
           ->setDecorators($this->My_standart_decorator);
       
       for($i=1; $i<5; $i++)
       {
           $select_rooms->addMultiOption($i, $i);
       }
       $form->addElement($select_rooms,'select_rooms');

      /* for($i=1; $i<5; $i++)
       {*/
           $room_occupents_adults = new Zend_Form_Element_Select("adults");
           $room_occupents_adults
               ->setLabel('Adults:')
               ->setRequired(true)
               ->setDecorators($this->My_standart_decorator);
           
           $room_occupents_child = new Zend_Form_Element_Select("children");
           $room_occupents_child
               ->setLabel('Children:')
               ->setDecorators($this->My_standart_decorator);
           
          // $form->addElement($room_occupents_adults,'adults');
         //  $form->addElement($room_occupents_child,'children');
           
      // }
        
        $search_submit = new Zend_Form_Element_Submit('search_submit');
        $search_submit
        	->setLabel('Search')
        	->setAttrib('class', 'btn')
        	->setDecorators(
                $this->My_button_decorators);
        
        $form->addElement($search_submit, 'search_submit');
        
        
        /*Hidden Elements*/
        $city_hidden_element = new Zend_Form_Element_Hidden('city_hotel_hidden');
        $city_hidden_element
            ->setDecorators($this->My_standart_decorator_without_lable);
        
        $form->addElement($city_hidden_element,'city_hotel_hidden');
        
        return $form;
        
    }

    public function My_add_booking ()
    {
        $form = new Zend_Form();
        
        $form->setName("booking_form")
            ->setDecorators($this->My_form_decorator)
            ->setAction(
                $this->My_front_URL_helper->url(
                        array(
                                'action' => 'searchresult'
                        ), 'my_default_route', true))
            ->setMethod('post')
            ->setAttrib('enctype', 'multipart/form-data');
        
        $m = new Zend_Form_Element_Text('text1');
        $m->setRequired(true)
            ->setLabel('asda')
            ->setDecorators($this->My_standart_decorator);
        
        $form->addElement($m);
        
        $sub = new Zend_Form_Element_Submit("submit_test");
        $sub->setLabel('asdasd')->setDecorators($this->My_button_decorators);
        
        $form->addElement($sub);
        return $form;
    }

    public function test_form ($from_array, $lang)
    {
        $form = new Zend_Form();
        
        $form->setName("booking_form")
            ->setDecorators($this->My_form_decorator)
            ->setMethod('post')
            ->setAttrib('enctype', 'multipart/form-data');
        
        foreach ($from_array as $val)
        {
            $input_text = new Zend_Form_Element_Text("{$val}");
            $input_text->setLabel($val)
                ->setRequired(true)
                ->setValue($val)
                ->setDecorators($this->My_standart_decorator);
            $form->addElement($input_text);
        }
        
        $Save_param = new Zend_Form_Element_Submit('save_val');
        $Save_param->setLabel('Save')->setDecorators(
                $this->My_button_decorators);
        
        $form->addElement($Save_param, 'save_val');
        
        $language = new Zend_Form_Element_Hidden('language');
        $language->setRequired(true)
            ->setValue($lang)
            ->setDecorators($this->My_standart_decorator_without_lable);
        
        $form->addElement($language);
        
        return $form;
    }
}