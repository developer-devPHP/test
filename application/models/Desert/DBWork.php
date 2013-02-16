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
    protected function My_Desert_insert_to_temp($data_array)
    {
        if (Zend_Session::namespaceIsset('Zend_User_Login'))
        {
            $user_info = Zend_Session::namespaceGet('Zend_User_Login');
            $user_params = $user_info['users_params'];
            $user_id = intval($user_params->user_ID);

            try
            {
                $this->My_DB->beginTransaction();

                $sql_delete = "DELETE FROM temp WHERE user_id = {$user_id}";
                $this->My_DB->getConnection()->query($sql_delete);

                foreach ($data_array['OptionInfoReply']['Option'] as $data)
                {
                    $service_type = $this->My_DB->quote('Desert');
                    $short_code = $this->My_DB->quote($data['Opt']);

                    $name = null;
                    $description = null;
                    $locality = null;
                    $stars = null;
                    $address = null;
                    $postcode = null;
                    $rate_name = null;
                    $rate_text = null;

                    if (!empty($data['SupplierName']))
                    {
                        $name = $this->My_DB->quote($data['SupplierName']);
                    }
                    if (!empty($data['Description']))
                    {
                        $description = $this->My_DB->quote($data['Description']);
                    }

                    if (!empty($data['LocalityDescription']))
                    {
                        $locality = $this->My_DB->quote($data['LocalityDescription']);
                    }
                    if (!empty($data['ClassDescription']))
                    {
                        $stars = $this->My_DB->quote($data['ClassDescription']);
                    }
                    if (!empty($data['Address1']))
                    {
                        $address = $this->My_DB->quote($data['Address1']);
                    }
                    if (!empty($data['PostCode']))
                    {
                        $postcode = $this->My_DB->quote($data['PostCode']);
                    }

                    $price = $this->My_DB->quote(mb_substr($data['AgentPrice'], 0, -2));
                    $currency = $this->My_DB->quote($data['Currency']);

                    if (!empty($data['RateName']))
                    {
                        $rate_name = $this->My_DB->quote($data['RateName']);
                    }
                    if (!empty($data['RateText']))
                    {
                        $rate_text = $this->My_DB->quote($data['RateText']);
                    }

                    // TODO SHARUNAKEM STEXIC
                    $sql_insert = "INSERT INTO temp
    				(user_id,service_type,short_code,name,description,locality,
    				stars,address,postcode,price,currency,rate_name,rate_text)
    				VALUES
    				({$user_id},{$service_type})";
                }
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
    }
}
