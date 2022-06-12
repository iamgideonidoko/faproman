<?php

namespace App\Controller;
use \App\Helper\View;
use \App\Lib\Fauna;

class UserController {
    // default time to live
    private $ttl = 30;

    // show login form
    public function login() {
        View::render('login.php', array(), 'Login - Faproman');
    }

    // show register form
    public function register() {
        View::render('register.php', array(), 'Register - Faproman');
    }

    // logout user
    public function logout() {
        // clear session
        session_unset();   
        session_destroy();
        header('Location: /login');
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

        $newUser = Fauna::createNewUser(strtolower($_POST['username']), password_hash($_POST['password1'], PASSWORD_DEFAULT), time());

        if (gettype($newUser) == 'string') {
            preg_match('/not unique/i', $newUser) ? array_push($errorMsgs, 'Username is taken, use another') : array_push($errorMsgs, 'Something went wrong');
            $_SESSION['register_errors'] = $errorMsgs;
            return header('Location: /register');
        }

        $_SESSION['logged_in_user'] = $newUser;
        $_SESSION['ttl'] = $this->ttl;

        return header('Location: /');        
    }
    

    // login user
    public function authenticate() {
        $errorMsgs = array();
        if (empty($_POST['username'])) array_push($errorMsgs, 'Username is required');
        if (empty($_POST['password'])) array_push($errorMsgs, 'Password is required');
        if (!preg_match('/^[A-Z0-9]*$/i', $_POST['username'])) array_push($errorMsgs, 'Username or password is incorrect');
     
        if (!empty($errorMsgs)) {
            $_SESSION['login_errors'] = $errorMsgs;
            return header('Location: /login');
        } 
        
        $user = Fauna::getUserByUsername($_POST['username']);

        // verify that user exist
        if (gettype($user) == 'string') {
            preg_match('/not found/i', $user) ? array_push($errorMsgs, 'Username or password is incorrect') : array_push($errorMsgs, 'Something went wrong');
            $_SESSION['login_errors'] = $errorMsgs;
            return header('Location: /login');
        }

        // verify that passowrd is correct
        if (!password_verify($_POST['password'], $user->password)) {
            array_push($errorMsgs, 'Username or password is incorrect');
            $_SESSION['login_errors'] = $errorMsgs;
            return header('Location: /login');
        }

        $_SESSION['logged_in_user'] = $user;
        $_SESSION['ttl'] = $this->ttl;

        return header('Location: /'); 
    }
    
}