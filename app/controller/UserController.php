<?php

namespace App\Controller;
use \App\Helper\View;

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
        echo 'Input from register form';

        var_dump($_POST);
    }
    
}