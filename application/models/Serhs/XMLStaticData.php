<?php

class Application_Model_Serhs_XMLStaticData
{

    private $My_static_http_client;

    private $My_static_data_client;

    private $My_static_data_branch;

    private $My_static_data_password;

    public function __construct ()
    {
        $this->My_static_http_client = new Zend_Http_Client(null, 
                array(
                        'timeout' => 200
                ));
        $this->My_static_http_client->setUri(
                'http://wsstatic.serhstourism.com/XmlServices/SoapAccess');
        
        $this->My_static_data_client = 'AKATRA';
        $this->My_static_data_branch = '14486';
        $this->My_static_data_password = '059it7uzyp';
    }

    private function My_xml_to_array_static ($xml)
    {
        $send = new SimpleXMLElement($xml);
        // $send->addAttribute('encoding', 'UTF-8');
        // header('Content-type: text/xml');
        // echo $send->asXML(); exit;
        $this->My_static_http_client->setRawData($xml, 'text/xml')->request(
                'POST');
        
        $pageBody = $this->My_static_http_client->request('POST')->getBody();
        // print_r($pageBody);exit();
        // $doc = new DOMDocument();
        // $doc->loadXML($pageBody);
        // print_r( $doc->documentElement ); exit;
        
        $mijankyal = str_replace('S:', '', $pageBody);
        $mijankyal = str_replace('ns2:', '', $mijankyal);
        // echo $a; exit;
        @$xml_response = simplexml_load_string($mijankyal);
        if ($xml_response === false)
        {
            $result_array = "We have some problem to show result";
            
            return $result_array;
        }
        else
        {
            $result_array = Zend_Json::decode(Zend_Json::encode($xml_response), 
                    Zend_Json::TYPE_ARRAY);
            
            return $result_array['Body'];
        }
        
    }

    public function My_get_countries ()
    {
        $xml = <<<XML
       <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
            xmlns:ser="http://ws.serhstourism.com/serhstourism_v5_0/">
        <soapenv:Header/>
        <soapenv:Body>
            <ser:GET_COUNTRIESRequest version="5.0" sessionId="?">
            <client code="{$this->My_static_data_client}" branch="{$this->My_static_data_branch}" password="{$this->My_static_data_password}"/>
            <language code="ENG"/>
       
            </ser:GET_COUNTRIESRequest>
        </soapenv:Body>
       </soapenv:Envelope>
XML;
        $result_array = $this->My_xml_to_array_static($xml);
        
        if (!is_string($result_array))
        {
            if ($result_array['GET_COUNTRIESResponse']['status']['@attributes']['code'] == 0)
            {
                $result_array = $result_array['GET_COUNTRIESResponse']['countries']['country'];
                
                return $result_array;
            }
            else
            {
                $result_array = $result_array['GET_COUNTRIESResponse']['status']['@attributes']['name'];
                
                return $result_array;
            }
        }
        else
        {
            return $result_array;
        }
    }

    public function My_get_cities ($country_code)
    {
        $xml = <<<XML
        
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
        	xmlns:ser="http://ws.serhstourism.com/serhstourism_v5_0/">
        	<soapenv:Header />
        	<soapenv:Body>
        		<ser:GET_CITIESRequest version="5.0" sessionId="?">
        			<client code="{$this->My_static_data_client}" branch="{$this->My_static_data_branch}" password="{$this->My_static_data_password}"/>
        			<language code="ENG" />
        			
        			<country code="{$country_code}" />
        		</ser:GET_CITIESRequest>
        	</soapenv:Body>
        </soapenv:Envelope>
XML;
        $result_array = $this->My_xml_to_array_static($xml);
        if (!is_string($result_array))
        {
          //  return $result_array;
            if ($result_array['GET_CITIESResponse']['status']['@attributes']['code'] == 0)
            {
                $result_array = $result_array['GET_CITIESResponse']['country']['regions']['region'];
                
                return $result_array;
            }
            else
            {
                $result_array = $result_array['GET_CITIESResponse']['status']['@attributes']['name'];
                
                return $result_array;
            }
        }
        else
        {
            return $result_array;
        }
    }

    public function My_get_accommodations ($country_code)
    {
        $xml = <<<XML
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
        	xmlns:ser="http://ws.serhstourism.com/serhstourism_v5_0/">
        	<soapenv:Header />
        	<soapenv:Body>
        		<ser:GET_ACCOMMODATIONS_INFORequest version="5.0" sessionId="?">
        			<client code="{$this->My_static_data_client}" branch="{$this->My_static_data_branch}" password="{$this->My_static_data_password}" />
        			<language code="ENG" /> 
        			        
        			<country code="{$country_code}"/>
        		</ser:GET_ACCOMMODATIONS_INFORequest>
        	</soapenv:Body>
        </soapenv:Envelope>
XML;
        // {$country_code}
        $result_array = $this->My_xml_to_array_static($xml);
        if (!is_string($result_array))
        {
            if ($result_array['GET_ACCOMMODATIONS_INFOResponse']['status']['@attributes']['code'] == 0)
            {
                $result_array = $result_array['GET_ACCOMMODATIONS_INFOResponse']['accommodations']['accommodation'];
            
                return $result_array;
            }
            else
            {
                $result_array = $result_array['GET_ACCOMMODATIONS_INFOResponse']['status']['@attributes']['name'];
            
                return $result_array;
            }
        }
        
        else
        {
            return $result_array;
        }
    }
}