<?php
 
// Load Slim framework
error_reporting(-1);
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);
 
require_once 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
 
global $app;
$app = new \Slim\Slim(array(
'debug' => true
));
 
echo 'REQUEST_URI: '.$_SERVER['REQUEST_URI'].'<br/>QUERY_STRING: '.$_SERVER['QUERY_STRING'].'<br/>';
 
$app->get('/', function() use ($app) {
echo "This is the root.";
});
 
$app->get('/test', function() use ($app) {
echo "This is a test.";
});
 
$app->error(function (\Exception $e) use ($app) {
echo 'This is an Error 500.';
});
 
$app->notFound(function () use ($app) {
echo 'This is an Error 404.';
});
 
// Run Slim Application
$app->run();