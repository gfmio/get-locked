<?php
session_start();

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

// User routes

$app->get('/users', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->post('/users', function() use ($app) { 
    // ...
    $app->render(200,array(
        'msg' => 'msg'
    ));
});
$app->put('/users', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->delete('/users', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });

$app->get('/users/current', function() use ($app) {
	 // ...
    $app->render(200,array(
        'msg' => 'msg'
    ));
});
$app->post('/users/current', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->put('/users/current', function() use ($app) {
     // ...
    $app->render(200,array(
        'msg' => 'msg'
    ));
});
$app->delete('/users/current', function() use ($app) {
    // ...
    $app->render(200,array(
        'msg' => 'msg'
    ));
});

// Session routes (login, logout)

$app->get('/session', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->post('/session', function() use ($app) {
	// ...
    $app->render(200,array(
        'msg' => 'msg'
    ));
});
$app->put('/session', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->delete('/session', function() use ($app) {
	// ...
    $app->render(200,array(
        'msg' => 'msg'
    ));
});

// Lock routes

$app->get('/locks', function() use ($app) {
    // ...
    $app->render(200,array(
        'msg' => 'msg'
    ));
});
$app->post('/locks', function($lock) use ($app) {
    // ...
    $app->render(200,array(
        'msg' => 'msg'
    ));
});
$app->put('/locks', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->delete('/locks', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });

$app->get('/locks/:lock', function() use ($app) {
    // ...
    $app->render(200,array(
        'msg' => 'msg'
    ));
});
$app->post('/locks/:lock', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->put('/locks/:lock', function() use ($app) {
    // ...
    $app->render(200,array(
        'msg' => 'msg'
    ));
});
$app->delete('/locks/:lock', function() use ($app) {
    // ...
    $app->render(200,array(
        'msg' => 'msg'
    ));
});

// Log routes

$app->get('/logs/user/:user', function() use ($app) {
	$app->render(200,array(
        'msg' => 'msg'
    ));
});
$app->post('/users/:user', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->put('/users/:user', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->delete('/users/:user', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });

$app->get('/logs/lock/:lock', function() use ($app) {
	$app->render(200,array(
        'msg' => 'msg'
    ));
});
$app->post('/locks/:lock', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->put('/locks/:lock', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->delete('/locks/:lock', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });

// Error routes
 
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
