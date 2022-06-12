<?php

namespace App\Controller;
use \App\Helper\View;
use \App\Lib\Fauna;

class UserController {

     // show login form
     public function login() {
        View::render('login.php', array(), 'Login - Faproman');
    }

    // show register form
    public function register() {
        View::render('register.php', array(), 'Register - Faproman');
    }

    // create new user
    public function create() {
        $errorMsgs = array();
        if (empty($_POST['username'])) array_push($errorMsgs, 'Username is required');
        if (!preg_match('/^[A-Z0-9]*$/i', $_POST['username'])) array_push($errorMsgs, 'Username can only contain alphanumeric characters');
        if (empty($_POST['password1'])) array_push($errorMsgs, 'Password is required');
        if ($_POST['password1'] != $_POST['password2']) array_push($errorMsgs, 'Passwords must be the same');
     
        if (!empty($errorMsgs)) {
            $_SESSION['register_errors'] = $errorMsgs;
            return header('Location: /register');
        } 

        $newUser = Fauna::createNewUser(strtolower($_POST['username']), $_POST['password1'], time());

        if (gettype($newUser) == 'string') {
            preg_match('/not unique/i', $newUser) ? array_push($errorMsgs, 'Username is taken, use another') : array_push($errorMsgs, 'Something went wrong');
            $_SESSION['register_errors'] = $errorMsgs;
            return header('Location: /register');
        }

        echo '$newUser => ';

        var_dump($newUser);

        echo '<br>';
        echo '<br>';
        echo 'new user type => ', gettype($newUser);
        echo '<br>';
        echo '<br>';
        echo 'id of user', $newUser->_id;
        echo '<br>';
        echo '<br>';

        print_r($newUser);

        
    }
    

    // create new user
    public function authenticate() {
        $errorMsgs = array();
        if (empty($_POST['username'])) array_push($errorMsgs, 'Username is required');
        if (empty($_POST['password'])) array_push($errorMsgs, 'Password is required');
        if (!preg_match('/^[A-Z0-9]*$/i', $_POST['username'])) array_push($errorMsgs, 'Username or password is incorrect');
     
        if (!empty($errorMsgs)) {
            $_SESSION['login_errors'] = $errorMsgs;
            return header('Location: /login');
        } 
        
        echo 'Input from login form';
        
        var_dump($_POST);
    }
    
}