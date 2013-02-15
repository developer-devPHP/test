<?php
// recursive xml traversal:
/*
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
*/

function ReadXml($xmlstr)
{
    $p = xml_parser_create();
    xml_parser_set_option ($p, XML_OPTION_CASE_FOLDING, 0);
    xml_parse_into_struct($p, $xmlstr, $vals);
    xml_parser_free($p);
    return
    ($vals[0]['tag'].PHP_EOL.
            $vals[1]['tag'].': '.$vals[1]['value'].PHP_EOL.
            $vals[2]['tag'].': '.$vals[2]['value'].PHP_EOL.
            $vals[3]['tag'].': '.$vals[3]['value'].PHP_EOL.
            $vals[4]['tag'].': '.$vals[4]['value'].PHP_EOL);
}
// (sql) select the second highest id from user table:

// SELECT id FROM user ORDER BY id DESC LIMIT 1,1

 //SELECT MAX(id) FROM user WHERE id NOT IN (SELECT MAX(id) FROM user )

// get checkbox values from POST:
/*
$res = array();
while(list($checkbox,) = each($_POST))
{
    $res[] = intval(substr($checkbox,strpos($checkbox,'_') + 1));
}
sort($res);
echo implode(' ',$res);
*/
$res = array();
foreach($_POST as $key => $value) {
    $res[] = intval(substr($key,strrpos($key,'_') + 1));
}
sort($res);
echo implode(' ',$res);

// get unique array elements:

function GetUniqueOnes($arr)
{
    $res = implode(',',array_unique($arr));

    return $res;
}

//generate random password:

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

function GeneratePassword2($length, $chars)
{
    //return substr(str_shuffle($chars), 0, $length);
    
    return substr(str_shuffle(str_repeat($chars,$length)), 0, $length);
}

// split email addresses:

function SplitEmailAddress($address)
{
    list($user, $domain) = explode('@',$address);
    return array('user' => $user, 'domain' => $domain);
}


// the most challenging task (for me). Phone regexps:

function ReformatPhoneNumber($number)
{
    if (preg_match('/^(\d[ -]?){7,12}$/', $number, $matches))
    {
        return preg_replace('/[ -]/', '', $number);
    }

    throw new Exception('Invalid phone number');
}

// get longest string in arguments:

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

function GetLongestString2()
{
    return max(array_map(strlen, func_get_args()));
    
}

// find maximum in nested array:


function MaxArray($arr)
{
    $GLOBALS['max'] = 0;
    array_walk_recursive($arr,create_function('$item,$key','if($item > $GLOBALS["max"]) $GLOBALS["max"] = $item;'));
    return $GLOBALS['max'];
}

function MaxArray2($arr) {
    $max = 0;
    foreach($arr as $a) {
        $tmp = is_array($a) ? MaxArray($a) : $a;
        $max = ($tmp > $max) ? $tmp : $max;
    }
    return $max;
}

//output all numbers divisable by 8 from 200 to 600 inclusive:

for($i = 200; $i <= 592; $i+=8)
{
    echo $i.',';
}
echo $i;

$i=200;
while($i%8!=0)
{
    $i++;
}
while($i<=600)
{
    echo $i;
    if($i<600)
    {
        echo ",";
    }
    $i+=8;
}

