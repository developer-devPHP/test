<?php

class Application_Model_Desert_XMLWork extends Application_Model_Desert_DBWork
{

    private $My_http_client;

    private $My_agent_id;

    private $My_agent_password;
    
  
    public function __construct ()
    {
        // TODO  class constructor init
        parent::__construct();
        $this->My_http_client = new Zend_Http_Client(null, 
                array(
                        'timeout' => 200
                ));
        
        $this->My_http_client->setUri(
                "http://80.227.67.214:8080/iComTest/servlet/conn"
                );// OLD "http://80.227.67.213:8080/iComDA_UAE/servlet/conn"  
        
        // http://80.227.67.214:8080/iComTest/servlet/conn
        
        $this->My_agent_id = 'KAN001';
        $this->My_agent_password = 'KANXL2012'; // KANXXX
        /*
         * test account <AgentID>KAN001</AgentID> <Password>XMLTEST</Password>
         * http://80.227.67.213:8080/iComDA_Testdata/servlet/conn
         */
        
    }

    private function My_xml_to_array ($xml)
    {
        try {
        $send = new SimpleXMLElement($xml);
        // $send->addAttribute('encoding', 'UTF-8');
        // echo $send->asXML(); //
        // print_r($send->asXML());exit;
        $this->My_http_client->setRawData($send->asXML(), 'text/xml')
            ->request('POST');
        
        $pageBody = $this->My_http_client->request('POST')->getBody();
        // print_r($pageBody);exit;
        @$xml_response = simplexml_load_string($pageBody);
      // Zend_Zend_Debug::dump($xml_response);exit;
      
        if ($xml_response === false)
        {
            $result_array = "We have some problem to show result";
        }
        else
        {
        	//throw new Exception('Timeout error more 200 seconds',500);
        	$result_array = $xml_response;
            	// = //$xml_response; //Zend_Json::decode(Zend_Json::encode($xml_response)); //Zend_Json::TYPE_ARRAY
        }
        
        // json_decode(json_encode((array) simplexml_load_string($pageBody)),
        // 1); //stringqcem
        
        // $this->My_PDF->My_create_PDF($xmlread['OptionInfoReply']['Option'][0]['OptGeneral']['Description']);
        return $result_array;
        }
        catch (Exception $e)
        {
        	if(APPLICATION_ENV == 'development')
    		{
    			echo 'Desert function '.__FUNCTION__.' in class '.__CLASS__.' directory '.dirname(__FILE__).' on line'. __LINE__ .' <br>';
    			print_r($e->getMessage());
    			exit();
    		}
    		else
    		{
    			return false;
    		}
        }
    }
    
    public function My_Desert_get_countrys()
    {
    	$xml = <<<XML
    	<!DOCTYPE Request SYSTEM "hostConnect_2_77_310.dtd">
		<Request>
			<GetSystemSettingsRequest>
				<AgentID>{$this->My_agent_id}</AgentID>
    			<Password>{$this->My_agent_password}</Password>
			</GetSystemSettingsRequest>
		</Request>
XML;
        $result_xml_obj = $this->My_xml_to_array($xml);
    	
    	if ( isset($result_xml_obj->GetSystemSettingsReply->Countries))
    	{
    		return $result_xml_obj->GetSystemSettingsReply->Countries;
    	}
    	else
    	{
    		return false;
    	}
    }

    public function My_Desert_get_cities ()
    {
         /*<<<EOD
		<!DOCTYPE Request SYSTEM "hostConnect_2_77_310.dtd">
		<Request>
			<GetLocationsRequest>
				<AgentID>{$this->My_agent_id}</AgentID>
    			<Password>{$this->My_agent_password}</Password>
			</GetLocationsRequest>
		</Request>
EOD;*/
    	/*
    	 * <!DOCTYPE Request SYSTEM "hostConnect_2_77_310.dtd">
 
<Request>
  <SupplierInfoRequest>
   <AgentID>{$this->My_agent_id}</AgentID>
    <Password>{$this->My_agent_password}</Password>
    <SupplierCode>??????</SupplierCode>
  </SupplierInfoRequest>
</Request>
    	 * 
    	 * */
        $xml = <<<XML
        <!DOCTYPE Request SYSTEM "hostConnect_2_77_310.dtd">
	<Request>
			<GetLocationsRequest>
				<AgentID>{$this->My_agent_id}</AgentID>
    			<Password>{$this->My_agent_password}</Password>
			</GetLocationsRequest>
		</Request>
XML;
        $result_array = $this->My_xml_to_array($xml);

        if ( isset($result_array->GetLocationsReply->Locations))
        {
            return $result_array->GetLocationsReply->Locations;
        }
        else
        {
            return false;
        }
    }

    public function My_Desert_get_services ()
    {
        $xml = <<<EOD
		
		<!DOCTYPE Request SYSTEM "hostConnect_2_77_310.dtd">
		<Request>
			<GetServicesRequest>
				<AgentID>{$this->My_agent_id}</AgentID>
    			<Password>{$this->My_agent_password}</Password>
			</GetServicesRequest>
		
		</Request>
EOD;
        $result_array = $this->My_xml_to_array($xml);
        if (is_array($result_array))
        {
            return $result_array['GetServicesReply']['TPLServices']['TPLService'];
        }
        else
        {
            return false;
        }
    }

    public function My_Desert_get_SupplierInfo ()
    {
        $xml = <<<EOD
		
		<!DOCTYPE Request SYSTEM "hostConnect_2_77_310.dtd">
		<Request>
			<SupplierInfoRequest>
				<AgentID>{$this->My_agent_id}</AgentID>
    			<Password>{$this->My_agent_password}</Password>
				<SupplierCode>??????</SupplierCode>
			</SupplierInfoRequest>	
		</Request>
EOD;
        $result_array = $this->My_xml_to_array($xml);
        if (is_array($result_array))
        {
            return $result_array['SupplierInfoReply']['Suppliers']['Supplier'];
        }
        
        else
        {
            return false;
        }
    }

    public function My_Desert_get_all_info ()
    {
        $xml = <<<EOD
		
		<!DOCTYPE Request SYSTEM "hostConnect_2_77_310.dtd">
		<Request>
			<OptionInfoRequest>
				<AgentID>{$this->My_agent_id}</AgentID>
    			<Password>{$this->My_agent_password}</Password>
				<Opt>???AC????????????</Opt>
				<Info>G</Info>
				<SortOrder>
					<SortField>
							<FieldName>suppliername</FieldName>
					</SortField>
				</SortOrder>
			</OptionInfoRequest>
		</Request>
EOD;
        $result_array = $this->My_xml_to_array($xml);
       
        if (isset($result_array->OptionInfoReply)&& !empty($result_array->OptionInfoReply))
        {
            return $result_array->OptionInfoReply;
        }
        
        else
        {
            return false;
        }
    }

    public function My_Desert_get_city_supplier ($city_and_supplier_kaper)
    {
        // $result_array = array();
        echo "<pre>";
        $i = 0;
        // print_r($city_and_supplier_kaper);exit;
        foreach ($city_and_supplier_kaper as $kaper)
        {
            if ($kaper['supplier_code'] == '000AED')
            {
                continue;
            }
            $xml = <<<XML
	
			<!DOCTYPE Request SYSTEM "hostConnect_2_77_310.dtd">
			
			<Request>
			
				 <OptionInfoRequest>
			    	<AgentID>{$this->My_agent_id}</AgentID>
    			    <Password>{$this->My_agent_password}</Password>
			    	<Opt>{$kaper['city_shortcode']}AC{$kaper['supplier_code']}?????</Opt>
					<MaximumOptions>1</MaximumOptions>		
							
			  </OptionInfoRequest>			
			</Request>
	
XML;
            $xml_array = $this->My_xml_to_array($xml);
            $result_array[$i] = $xml_array;
            $i ++;
            /*
             * if(is_array($xml_array)) { $check_array = $xml_array;
             * $result_array[$i] = $check_array; $i++; //	print_r($xml_array);
             * if (!empty($check_array)) { } //return
             * $xml_array['OptionInfoReply']['Option']; }
             */
        }
        ;
        echo $i;
        print_r($result_array);
    }

    public function My_desert_test ()
    {
        $xml = <<<XML
       <!DOCTYPE Request SYSTEM "hostConnect_2_77_310.dtd">
<Request>
	<GetLocationsRequest >
		<AgentID>{$this->My_agent_id}</AgentID>
		<Password>{$this->My_agent_password}</Password>
		
	</GetLocationsRequest >
</Request>
XML;
        $result_array = $this->My_xml_to_array($xml);
        echo "<pre>";
        print_r($result_array);
        exit();
    }
    
    public function My_Desert_get_search_info($search_options)
    {
    	try 
    	{
    		//$today = date('d-Y',time());    
    		$check_in_date = $search_options['check_in_date'];
    		$check_out_date = $search_options['check_out_date'];
    		$search_option_tag = Zend_Json::decode($search_options['city_hotel_hidden'],Zend_Json::TYPE_ARRAY);
    	
	    	$option = null;
	    	if(isset($search_option_tag['desert']['city']))
	    	{
	    		$option = $search_option_tag['desert']['city']."AC????????????";
	    	}
	    	elseif(isset($search_option_tag['desert']['hotel'])) 
	    	{
	    		$option = "???AC{$search_option_tag['desert']['hotel']}??????";
	    	}
	    	else 
	    	{
	    		return false;
	    	}
    	
	    	$cache_name =  preg_replace('/[^\p{L}\p{N}]/u', '_', 'Desert_from_'.$check_in_date.'_to_'.$check_out_date.'_value_'.$option);
	    	
	    	$cache_data = $this->My_cache->My_cache_set($cache_name);
	    	
	    	if($cache_data === true)
	    	{
		    	$xml = "
		
				<!DOCTYPE Request SYSTEM 'hostConnect_2_77_310.dtd'>
				<Request>
					 <OptionInfoRequest>
				    	<AgentID>{$this->My_agent_id}</AgentID>
				    	<Password>{$this->My_agent_password}</Password>
						<Opt>{$option}</Opt>
						<Info>GS</Info>
						<DateFrom>{$check_in_date}</DateFrom>
				    	<DateTo>{$check_out_date}</DateTo>
						<RoomConfigs>";
		    	
				      		
				 $xml .= "
				 			<RoomConfig>
				        		<Adults>1</Adults>
				        		<RoomType>SG</RoomType>
				      		</RoomConfig>
				    	</RoomConfigs>
				  </OptionInfoRequest>
				    	
				</Request>
				";
				 // <MaximumOptions>20</MaximumOptions>
				 $xml_obj = $this->My_xml_to_array($xml);
				 if (isset($xml_obj->OptionInfoReply)&& !empty($xml_obj->OptionInfoReply))
				 {
				 	$to_temp = $this->My_Desert_insert_to_temp($xml_obj->OptionInfoReply);
				 	
				 	$cache_time = 60 * 60 * 24;
				 	$this->My_cache->My_cache_set($cache_name, null, true, array('data_inserted_into_db'), $cache_time);
				 	
				 	return $to_temp;
				 }
				 
				 else
				 {
				 	return false;
				 }
				 //$cache_data = $this->My_cache->My_cache_set($cache_name,null,true,$xml_array);
				 
	    	}
	    	else 
	    	{
	    		return true;
	    	}
		 
    	}
    	catch (Exception $e)
    	{
    		if(APPLICATION_ENV == 'development')
    		{
    			echo 'Desert function '.__FUNCTION__.' in class '.__CLASS__.' directory '.dirname(__FILE__).' on line'. __LINE__ .' <br>';
    			print_r($e->getMessage());
    			exit();
    		}
    		else
    		{
    			return false;
    		}
    	}
    }

    public function My_Desert_Adventures_xml ()
    {
        // $a = substr_replace('10200' ,"",-2);
        // echo $a;exit;
        $xml = <<<XML

<!DOCTYPE Request SYSTEM "hostConnect_2_77_310.dtd">

<Request>

	 <OptionInfoRequest>
    	<AgentID>{$this->My_agent_id}</AgentID>
    	<Password>{$this->My_agent_password}</Password>
		<Opt>DXBAC????????????</Opt>		
		<Info>GS</Info>
		<DateFrom>2012-09-24</DateFrom>
    	<DateTo>2012-09-25</DateTo>
		<RoomConfigs>
      		<RoomConfig>
        		<Adults>7</Adults>
				<Children>99</Children>
				<Infants>99</Infants>
        		<RoomType>SG</RoomType>
      		</RoomConfig>
    	</RoomConfigs>
  </OptionInfoRequest>
    	        			
</Request>

XML;
        /*
         * <LocalityDescription>Ras Al Khaimah Beach</LocalityDescription>
         * <ClassDescription></ClassDescription> <SupplierName></SupplierName>
         * <Opt>?????????????????</Opt> <DateFrom>2012-09-14</DateFrom>
         * <DateTo>2012-09-15</DateTo> <RoomConfigs> <RoomConfig>
         * <Adults>2</Adults> <RoomType>TW</RoomType> </RoomConfig>
         * </RoomConfigs>
         */
		
	/* SupplierInfoRequest  <SupplierCode>??????</SupplierCode>
	 * GetLocationsRequest 
	 * GetServicesRequest 
	 * <OptionInfoRequest>
	 * 
	 * 
    <AgentID>KAN001</AgentID>
    <Password>XMLTEST</Password>
    <Opt>?????????????????</Opt>
    <Info>G</Info>
  </OptionInfoRequest>*/	
		
	$xml_array = $this->My_xml_to_array($xml);
        echo "<pre>";
        print_r($xml_array);
    }
    
    public function MY_Desert_add_service()
    {
        $xml = <<<XML
        
        <!DOCTYPE Request SYSTEM "hostConnect_2_77_000.dtd">

		<Request>
		   <AddServiceRequest>
                
		    <AgentID>{$this->My_agent_id}</AgentID>
    		<Password>{$this->My_agent_password}</Password>
                
		     <NewBookingInfo>
		       <Name>Smith Mr/Mrs</Name>
		       <QB>B</QB>
		     </NewBookingInfo>
                
		     <Opt>DXBACMJAQDXPLADCO</Opt>
		     <RateId>default</RateId>
		     <DateFrom>2011-12-01</DateFrom>
		     <RoomConfigs>
		        <RoomConfig>
		          <Adults>2</Adults>
		          <RoomType>DB</RoomType>
		          <PaxList>
		            <PaxDetails>
		             <Title>Mr</Title>
		             <Forename>Craig</Forename>
		             <Surname>Smith</Surname>
		             <PaxType>A</PaxType>
		            </PaxDetails>
		            <PaxDetails>
		             <Title>Mrs</Title>
		             <Forename>Sarah</Forename>
		             <Surname>Smith</Surname>
		             <PaxType>A</PaxType>
		            </PaxDetails>
		          </PaxList>
		        </RoomConfig>
		        <RoomConfig>
		          <Adults>1</Adults>
		          <RoomType>SG</RoomType>
		          <PaxList>
		            <PaxDetails>
		             <Title>Mr</Title>
		             <Forename>John</Forename>
		             <Surname>Jones</Surname>
		             <PaxType>A</PaxType>
		            </PaxDetails>
		          </PaxList>
		        </RoomConfig>
		     </RoomConfigs>
		     <SCUqty>3</SCUqty>
		   </AddServiceRequest>
		</Request>
        
XML;
    }
    
}