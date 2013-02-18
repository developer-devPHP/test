<?php
/************************************************************* 
 * This script is developed by Arturs Sosins aka ar2rsawseen, http://webcodingeasy.com 
 * Fee free to distribute and modify code, but keep reference to its creator 
 *
 * This class can generating sitemap by parsing given URL and recursively follow same domain links 
 * using multiple curl requests, which makes parsing much more faster than file_get_contents or default curl requests.
 * You can create sitemaps for multiple domains or subdomains and specify which URLs to ignore.
 * Then you can retrieve array of gathered links and generate valid http://www.sitemaps.org/schemas/sitemap/0.9 xml based sitemap.
 * You can also notify such services as Google, Yahoo, Bing, Ask and Moreover about your sitemap update.
 * 
 * For more information, examples and online documentation visit:  
 * http://webcodingeasy.com/PHP-classes/Sitemap-generator-class
**************************************************************/

//setting to no time limit, 
set_time_limit(0);

//declaring class instance
include("./sitemap.class.php");
$sitemap = new sitemap();

//optionally set proxy server name and port or ip and port
//comment-out or set to an empty string to disable proxy use
//$sitemap->set_proxy('10.1.1.1:8080');

//setting rules to ignore URLs which contains these substrings
$sitemap->set_ignore(array("javascript:", "#", ".css", ".js", ".ico", ".jpg", ".png", ".jpeg", ".swf", ".gif"));

//parsing one page and gathering links
$sitemap->get_links("");

//parsing other page and gathering links
//$sitemap->get_links("http://cms.annar2r.info");

//return URL list as array
//$arr = $sitemap->get_array();

//echo "<pre>";
//print_r($arr);
//echo "</pre>";

header ("content-type: text/xml");
//generating sitemap
$map = $sitemap->generate_sitemap();

//submitting site map to Google, Yahoo, Bing, Ask and Moreover services
$sitemap->ping("http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);

echo $map;
?>