<?php

//set the url to send api request
$wsdl="https://securedwebapp.com/api/service.asmx?WSDL";
$array=array(
    'UserName' => 'your username',
    'Password' => 'your password',
    'QuoteID' => your quote id
);


//print_r($array);
echo '<br>';

//initiate soap client
$client = new SoapClient($wsdl,$array);
//$result = $client->GetQuoteByID($array);
//echo  gettype($result);
echo '<br>';
//print_r($result);
echo '<br>';

//set parameters
$parameters['UserName'] = "your username";
$parameters['Password'] = "your password";
$parameters['QuoteNumber'] = "your quote number";
//$response = $client->GetCustomers($parameters);
//return data using soap request
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
$passv['UserName'] = "your username";
$passv['Password'] = "your password";
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
    $apiurl = 'https://youraccountname.api-us1.com/api/3/contact/sync';
    $token = 'your api token';
    $httphead = array('Api-Token : your api token','Accept: application/json',
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
