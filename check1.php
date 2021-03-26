<?php

$wsdl="https://securedwebapp.com/api/service.asmx?WSDL";
$array=array(
    'UserName' => 'ripul.chhabra@sowlab.com',
    'Password' => 'kashflow',
    'QuoteID' => 1
);


//print_r($array);
echo '<br>';

$client = new SoapClient($wsdl,$array);
//$result = $client->GetQuoteByID($array);
//echo  gettype($result);
echo '<br>';
//print_r($result);
echo '<br>';


$parameters['UserName'] = "ripul.chhabra@sowlab.com";
$parameters['Password'] = "kashflow";
$parameters['QuoteNumber'] = "1";
//$response = $client->GetCustomers($parameters);
$rond = $client->GetQuoteByNumber ($parameters);
//print_r($response);
echo '<br>';
//$json=json_encode($response);
//echo $json;
echo '<br>';
print_r($rond);
echo '<br>';

/*if quote is okay customer id is retrieved*/
$der = json_decode(json_encode($rond), true);
if ($der['Status'] == "OK")
{
$customerID = $der['GetQuoteByNumberResult']['CustomerID'];
$passv['UserName'] = "ripul.chhabra@sowlab.com";
$passv['Password'] = "kashflow";
$passv['CustomerID'] = $customerID;
$res = $client->GetCustomerByID($passv);
$actsend = json_decode(json_encode($res), true);
echo '<br>';
print_r($res);
echo '<br>';
$email = $actsend['GetCustomerByIDResult']['Email'];
$fName = $actsend['GetCustomerByIDResult']['ContactFirstName'];
$sName = $actsend['GetCustomerByIDResult']['ContactLastName'];
$phone  = $actsend['GetCustomerByIDResult']['Mobile'];
$address = $actsend['GetCustomerByIDResult']['Address1'];
$postcode = $actsend['GetCustomerByIDResult']['Postcode'];
$jsontosend = array("contact" => array(
    "email" => $email,
    "firstName" => $fName,
    "lastName" => $sName,
    "phone" => $phone));
$encodedjson=json_encode($jsontosend);
}


/* activeCampaign API */
if(isset($email)||isset($fName)){
    $sendp = '{"contact":{"email":"ripul.chhabra@sowlab.com","firstName":"Ripul","lastName":"Chhabra","phone":"9846383798"}}';
    $apiurl = 'https://sowlab1616567849.api-us1.com/api/3/contact/sync';
    $token = '01ff8dae395081e6f65bacda4bf4d5fc72b036c276f22b9453d46bb8b2ba0c62fef1f56a';
    $httphead = array('Api-Token : 01ff8dae395081e6f65bacda4bf4d5fc72b036c276f22b9453d46bb8b2ba0c62fef1f56a','Accept: application/json',
    'Content-Type: application/json',);
    $curl=curl_init();
    $a = curl_setopt($curl, CURLOPT_URL, $apiurl);
    $b =curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    $c =curl_setopt($curl, CURLOPT_POSTFIELDS, $sendp);
    $d =curl_setopt($curl, CURLOPT_HTTPHEADER, $httphead );
    $e =curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, false);
    $f =curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
    $resultfromserver = curl_exec($curl);
    curl_close($curl);
    $paid=json_decode($resultfromserver,true);
    echo $paid;
    echo 'Curl error: ' . curl_error($curl);
    echo '<br>';
    print_r($httphead);
    echo '<br>';
    echo $a;
    echo '<br>';
    echo $b;
    echo '<br>';
    echo $c;
    echo '<br>';
    echo $d;
    echo '<br>';
    //echo $e;
    echo '<br>';
    echo $f;
    echo '<br>';
    print_r($resultfromserver);
    echo gettype($resultfromserver);
    echo $encodedjson;
   
}

?>