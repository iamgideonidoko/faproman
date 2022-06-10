<?php

namespace App\Controller;
use \App\Helper\View;

class ProjectController {

    // home page
    public function index() {
        View::render('home.php', array(), 'Home Page');
    }
    
}