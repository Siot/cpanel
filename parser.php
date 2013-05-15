<?php header('Content-Type: text/xml');

$whmusername = "";
$whmpassword = "";

$xmlapi_module = $_REQUEST['cpanel_xmlapi_module'];
$xmlapi_func = $_REQUEST['cpanel_xmlapi_func'];
$xmlapi_apiversion = "2";
$xmlapi_args = urldecode($_REQUEST['args']);

$query = "https://www.domain.com:2083/xml-api/cpanel?user=khtxjczw&cpanel_xmlapi_module=". $xmlapi_module ."&cpanel_xmlapi_func=". $xmlapi_func ."&cpanel_xmlapi_version=". $xmlapi_apiversion . $xmlapi_args;


$curl = curl_init();		
# Create Curl Object
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);	
# Allow self-signed certs
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0); 	
# Allow certs that do not match the hostname
curl_setopt($curl, CURLOPT_HEADER,0);			
# Do not include header in output
curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);	
# Return contents of transfer on curl_exec
$header[0] = "Authorization: Basic " . base64_encode($whmusername.":".$whmpassword) . "\n\r";
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);  
# set the username and password
curl_setopt($curl, CURLOPT_URL, $query);			
# execute the query
$result = curl_exec($curl);
if ($result == false) {
	error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");	
# log error if curl exec fails
}
curl_close($curl);


$result = simplexml_load_string($result);
print $result->asXML();

?>
