<?php
 
// Load Slim framework
error_reporting(-1);
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);

require_once 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

require_once 'helpers/helpers.php';

global $app;
$app = new \Slim\Slim(array(
	'debug' => true
));

$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());
 
// $app->get('/', function() use ($app) {
// 	$app->render(200,array(
//         'msg' => 'msg'
//     ));
// });
 
$app->error(function (\Exception $e) use ($app) {
	$app->render(500,array(
        'msg' => 'error',
        'error' => true
    ));
});
 
$app->notFound(function () use ($app) {
	$app->render(404,array(
        'msg' => 'not found',
        'error' => true
    ));
});
 
// Run Slim Application
$app->run();
