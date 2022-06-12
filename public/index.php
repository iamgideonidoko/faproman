<?php
session_start();
/**
 * Autoload classes
 */ 
require __DIR__ . '/../vendor/autoload.php';

use \App\Controller\ProjectController;
use \App\Controller\UserController;

// if user is logged in but inactive for given TTL time then logout user
if (
    isset($_SESSION['logged_in_user']) && 
    isset($_SESSION['ttl']) && 
    isset($_SESSION['last_activity']) && 
    (time() - $_SESSION['last_activity'] > ($_SESSION['ttl'] * 60))
) {
    session_unset();
    session_destroy();
    header('Location: /login');    
} 
    
// record current time
$_SESSION['last_activity'] = time();

$router = new AltoRouter();

// routes
$router->addRoutes(array(
    array('GET','/', array(new ProjectController, 'index')),
    array('GET','/login', array(new UserController, 'login')),
    array('GET','/register', array(new UserController, 'register')),
    array('GET','/logout', array(new UserController, 'logout')),
    array('POST','/user/create', array(new UserController, 'create')),
    array('POST','/user/authenticate', array(new UserController, 'authenticate')),
    array('POST','/project/create', array(new ProjectController, 'create')),
    array('POST','/project/update', array(new ProjectController, 'update')),
    array('POST','/project/delete', array(new ProjectController, 'delete')),
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