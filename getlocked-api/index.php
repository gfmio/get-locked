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

$app->add(new \Slim\Middleware\SessionCookie(array(
    'expires' => '20 minutes',
    'path' => '/',
    'domain' => null,
    'secure' => false,
    'httponly' => false,
    'name' => 'slim_session',
    'secret' => 'CHANGE_ME',
    'cipher' => MCRYPT_RIJNDAEL_256,
    'cipher_mode' => MCRYPT_MODE_CBC
)));

$app->view(new \JsonApiView());
$app->add(new \JsonApiMiddleware());

// User routes

$app->get('/users', function() use ($app) { $app->render(403, array('msg' => 'forbidden', 'error' => true)); });
$app->post('/users', function() use ($app) { 
    // ob_start();
    // $allGetVars = $app->request->get();
    // $allPostVars = $app->request->post();
    // $allPutVars = $app->request->put();

    // var_dump($allGetVars);
    // var_dump($allPostVars);
    // var_dump($allPutVars);
    // $output = ob_get_contents();
    // ob_end_clean();

    $user = new User();
    echo "a";
    $user->setEmail($app->request->get("email"));
    echo "a";
    $user->setPassword($app->request->get("password"));
    echo "a";
    $user->insert();
    echo "a";
    die();

    $app->render(200,array(
        'user' => $user->id
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

$app->get('/locks/:lock/lock', function() use ($app) {
    $app->render(200,array(
        'msg' => 'msg'
    ));
});
$app->get('/locks/:lock/unlock', function() use ($app) {
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
