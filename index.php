<?php
require_once 'vendor/autoload.php';
use Guzzle\Http\Client;

define("TOKEN", "new");
define("SECRET", "guest");

//define("solutionId", "MyApp");
//define("consumerName", "Guzzle");
//define("vendorName", "Guzzle");
//define("productName", "Guzzle");
//define("productVersion", "1.x");

// Generate our Authorization Key
$authorizationKey = "Basic " . base64_encode(TOKEN . ':' . SECRET);

// Our SIF client
$client = new Client('http://rest3api.sifassociation.org', array(
  'request.options' => array(
    'headers' => array(
      'Authorization' => $authorizationKey,
      'Accept' => 'application/xml',
      'Content-Type' => 'application/xml',
    ),
  ),
));

// Create our environment
$xml = file_get_contents('environment.xml');
$request = $client->post('/api/environments/environment', array(), $xml);

// Send the request and get the response
$response = $request->send();
$environment = $response->xml();

// @TODO: Better handling?
if ($response->isSuccessful()){
  print "OK!\n";
} else {
  print "Something failed! \n";
}

// Get Session Token
$sessionToken = $environment->sessionToken;
print "OK! Got sessionToken! $sessionToken \n";

// Generate new Authentication Token
$authorizationKey = "Basic " . base64_encode($sessionToken . ':' . SECRET);

print "New Auth Token: $authorizationKey \n";

$client->setConfig(array('request.options' => array(
    'headers' => array(
      'Authorization' => $authorizationKey,
    ),
)));

// Get Zones
$request = $client->get('/api/zones', array());

// Send the request and get the response
$response = $request->send();
print $response->getBody();
$zones = $response->json();

print_r($zones);
