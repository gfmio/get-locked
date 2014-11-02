<?php
session_start();

// Load Slim framework
error_reporting(-1);
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);

require_once 'helpers/helpers.php';
require_once 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
 
global $app;
$app = new \Slim\Slim(array(
	'debug' => true,
	'templates.path' => './views'
));

$app->get('/', function() use ($app) {
	$app->render("landing.html");
});
$app->get('/get-started', function() use ($app) {
	$app->render("get-started.html");
});

$app->get('/locks', function() use ($app) {
	try {
		User::getCurrentUser();
		$app->render("locks.html");
	} catch (Exception $e) {
		$app->redirect('./get-started', 301);
	}
});
$app->get('/profile', function() use ($app) {
	try {
		User::getCurrentUser();
		$app->render("profile.html");
	} catch (Exception $e) {
		$app->redirect('./get-started', 301);
	}
});
$app->get('/log', function() use ($app) {
	try {
		User::getCurrentUser();
		$app->render("log.html");
	} catch (Exception $e) {
		$app->redirect('./get-started', 301);
	}
});

$app->get('/locks-new', function() use ($app) {
	try {
		User::getCurrentUser();
		$app->render("locks-new.html");
	} catch (Exception $e) {
		$app->redirect('./get-started', 301);
	}
});
$app->get('/locks-get', function() use ($app) {
	try {
		User::getCurrentUser();
		$app->render("locks-get.html");
	} catch (Exception $e) {
		$app->redirect('./get-started', 301);
	}
});
$app->get('/locks-log', function() use ($app) {
	try {
		User::getCurrentUser();
		$app->render("locks-log.html");
	} catch (Exception $e) {
		$app->redirect('./get-started', 301);
	}
});


// locks
// profile
// log
// /locks/new
// /locks/:lock
// /locks/:lock/log

$app->error(function (\Exception $e) use ($app) {
	$app->render("error500.html");
});
 
$app->notFound(function () use ($app) {
	$app->render("error404.html");
});
 
// Run Slim Application
$app->run();
