<?php

class Application_Model_Serhs_XMLWork
{

    private $My_booking_data_url;

    private $My_booking_data_client;

    private $My_booking_data_branch;

    private $My_booking_data_password;
    

    public function __construct ()
    {
        $this->My_booking_data_url = new Zend_Http_Client(null, 
                array(
                        'timeout' => 200
                ));
        
        $this->My_booking_data_url->setUri(
                "http://wstest.serhstourism.com/wsserhs/serhstourism");
        
        $this->My_booking_data_client = 'AKATRA';
        $this->My_booking_data_branch = '14486';
        $this->My_booking_data_password = 'AKATRAtest';
        
        /*
         * Client: AKATRA Branch: 14486 Password: AKATRAtest
         */
    }

    private function My_xmlstr_to_array ($xml)
    {
        $send = new SimpleXMLElement($xml);
        // $send->addAttribute('encoding', 'UTF-8');
      //   echo $send->asXML();
      //   print_r($send->asXML());exit;
        $this->My_booking_data_url->setRawData($send->asXML(), 'text/xml')
            ->request('POST');
        
        $pageBody = $this->My_booking_data_url->request('POST')->getBody();
        // print_r($pageBody);exit;
        @$xml_response = simplexml_load_string($pageBody);
        
        if ($xml_response === false)
        {
            $result_array = "We have some problem to show result";
        }
        else
        {
            $result_array = Zend_Json::decode(Zend_Json::encode($xml_response), 
                    Zend_Json::TYPE_ARRAY);
        }
        
        return $result_array;
    }

    public function My_accommodation_avail ()
    {
        $xml = <<<xml
          <request type="ACCOMMODATIONS_AVAIL" version="4.1" sessionId="?">
        	<client code="AKATRA" branch="14486" password="AKATRAtest" />
        	<language code="ENG" />
        	<searchCriteria>
        		<criterion type="0" code="city" value="60022" />
                <criterion type="1" code="accommodationCode" value=""/>
        		<criterion type="1" code="accommodationType" value="0" />
        		<criterion type="1" code="category" value="5" />
        		<criterion type="2" code="priceType" value="3" />
        		<criterion type="2" code="offer" value="" />
        		<criterion type="2" code="concept" value="" />
        		<criterion type="2" code="board" value="" />
        		<criterion type="2" code="cancelPolicies" value="1" />
        	</searchCriteria>
        	<period start="20121025" end="20121030" />
        	<rooms>
        		<room type="1" adults="2">
                </room>
        	</rooms>
        </request>
xml;
        $result = $this->My_xmlstr_to_array($xml);
        echo"<pre>";
        print_r($result);
    }
}