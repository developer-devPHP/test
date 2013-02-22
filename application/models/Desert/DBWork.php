<?php

class Application_Model_Desert_DBWork
{
    protected  $My_DB;
    protected $My_cache;

    protected function __construct()
    {
        $this->My_DB = Zend_Db_Table::getDefaultAdapter();
        $this->My_cache = new MyLib_Cache();
    }
    protected function My_Desert_insert_to_temp($data_obj_xml)
    {
        if (Zend_Session::namespaceIsset('Zend_User_Login'))
        {
            $user_info = Zend_Session::namespaceGet('Zend_User_Login');
            $user_params = $user_info['users_params'];
            $user_id = intval($user_params->user_ID);

            try
            {
                $this->My_DB->beginTransaction();

                $sql_delete = "DELETE FROM all_search_temp WHERE user_id = {$user_id}";
                $this->My_DB->getConnection()->query($sql_delete);

                foreach ($data_obj_xml->Option as $data)
                {
                    $service_type = $this->My_DB->quote('Desert');
                    $short_code = $this->My_DB->quote($data->Opt);

                    $name = 'NULL';
                    $description = 'NULL';
                    $locality = 'NULL';
                    $stars = 'NULL';
                    $address = 'NULL';
                    $postcode = 'NULL';
                    $rate_name = 'NULL';
                    $rate_text = 'NULL';

                    if (!empty($data->OptGeneral->SupplierName))
                    {
                        $name = $this->My_DB->quote($data->OptGeneral->SupplierName);
                    }
                    if (!empty($data->OptGeneral->Description))
                    {
                        $description = $this->My_DB->quote($data->OptGeneral->Description);
                    }

                    if (!empty($data->OptGeneral->LocalityDescription))
                    {
                        $locality = $this->My_DB->quote($data->OptGeneral->LocalityDescription);
                    }
                    if (!empty($data->OptGeneral->ClassDescription))
                    {
                        $stars = $this->My_DB->quote($data->OptGeneral->ClassDescription);
                    }
                    if (!empty($data->OptGeneral->Address1))
                    {
                        $address = $this->My_DB->quote($data->OptGeneral->Address1);
                    }
                    if (!empty($data->OptGeneral->PostCode))
                    {
                        $postcode = $this->My_DB->quote($data->OptGeneral->PostCode);
                    }
                    $price = mb_substr($data->OptStayResults->AgentPrice,-2);
                    $price = $this->My_DB->quote(mb_substr($data->OptStayResults->AgentPrice, 0, -2).'.'.$price);
                    
                    $currency = $this->My_DB->quote($data->OptStayResults->Currency);

                    if (!empty($data->OptStayResults->RateName))
                    {
                        $rate_name = $this->My_DB->quote($data->OptStayResults->RateName);
                    }
                    if (!empty($data->OptStayResults->RateText))
                    {
                        $rate_text = $this->My_DB->quote($data->OptStayResults->RateText);
                    }

                    // TODO SHARUNAKEM STEXIC
                    $sql_insert = "INSERT INTO all_search_temp
    				(user_id,service_type,short_code,name,description,locality,
    				stars,address,postcode,price,currency,rate_name,rate_text)
    				VALUES
    				({$user_id},{$service_type},{$short_code},{$name},{$description},{$locality},
    				{$stars},{$address},{$postcode},{$price},{$currency},{$rate_name},{$rate_text})";
    				
    				$this->My_DB->getConnection()->query($sql_insert);
                }
                $this->My_DB->commit();
                return true;
            }
            catch (Exception $e)
            {
                if (APPLICATION_ENV == 'development')
                {
                    $this->My_DB->rollBack();
                    echo 'Desert function' . __FUNCTION__ . 'in class' . __CLASS__ . 'directory ' . __DIR__ . '<br>';
                    print_r($e->getMessage());
                    exit();
                }
                else
                {
                    $this->My_DB->rollBack();
                    return false;
                }
            }
        }
        else 
        {
        	return false;
        }
    }
}
