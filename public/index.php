<?php
session_start();
/**
 * Autoload classes
 * */ 
require __DIR__ . '/../vendor/autoload.php';

use \App\Controller\ProjectController;
use \App\Controller\UserController;

$router = new AltoRouter();

// routes
$router->addRoutes(array(
    array('GET','/', array(new ProjectController, 'index')),
    array('GET','/login', array(new UserController, 'login')),
    array('GET','/register', array(new UserController, 'register')),
));

/* Match the current request */
$match = $router->match();


// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
    // call the action function and pass parameters
	call_user_func_array( $match['target'], $match['params'] ); 
} else {
	// no route was matched
    header("HTTP/1.0 404 Not Found");
    echo '404 - page not found';
}