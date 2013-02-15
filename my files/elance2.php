<?php
function ReadXml($xmlstr)
{
    static $res = '';
    $xml = new SimpleXMLElement($xmlstr);

    if(count($xml->children()))
    {
        $res .= $xml->getName().PHP_EOL;
        foreach($xml->children() as $child)
        {
            ReadXml($child->asXML());
        }
    }
    else
    {
        $res .= $xml->getName().': '.(string)$xml.PHP_EOL;
    }

    return $res;
}



//SELECT id FROM user ORDER BY id DESC LIMIT 1,1


$res = array();
while(list($checkbox,) = each($_POST))
{
    $res[] = intval(substr($checkbox,strpos($checkbox,'_') + 1));
}
sort($res);
echo implode(' ',$res);



//Write a function GetUniqueOnes, which accepts a single argument. The argument is an 
//array of integers, and the function should return the unique integers separated by commas 
function GetUniqueOnes($arr)
{
    $res = implode(',',array_unique($arr));

    return $res;
}

/// sdfsdf
function GeneratePassword ($length,$chars)
{
    $res = '';
    $char_length = strlen($chars);
    for($i = 0; $i < $length; $i++)
    {
        $res .= $chars[rand(0,$char_length)];
    }

    return $res;
}

//a assad

function SplitEmailAddress($address)
{
    list($user, $domain) = explode('@',$address);
    return array('user' => $user, 'domain' => $domain);
}


// as

function ReformatPhoneNumber($number)
{
    if (preg_match('/^(\d[ -]?){7,12}$/', $number, $matches))
    {
        return preg_replace('/[ -]/', '', $number);
    }

    throw new Exception('Invalid phone number');
}

//s
function GetLongestString()
{
    $length = 0;
    foreach(func_get_args() as $arg)
    {

        $var = strlen($arg);
        if($var > $length)
        {
            $length = $var;
        }
    }
    return $length;
}

//

function MaxArray($arr)
{
    $GLOBALS['max'] = 0;
    array_walk_recursive($arr,create_function('$item,$key','if($item > $GLOBALS["max"]) $GLOBALS["max"] = $item;'));
    return $GLOBALS['max'];
}


//

for($i = 200; $i <= 592; $i+=8)
{
    echo $i.',';
}
echo $i;