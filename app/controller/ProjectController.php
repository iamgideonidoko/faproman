<?php

namespace App\Controller;
use \App\Helper\View;
use \App\Lib\Fauna;

class ProjectController {

    // home page
    public function index() {
        View::render('home.php', array(), 'Home Page');
    }

    // edit page
    public function edit(string $id) {
        View::render('edit.php', array('projectId' => $id), 'Edit Project');
    }

    // create new user
    public function create() {
        $errorMsgs = array();
        if (empty($_POST['name'])) array_push($errorMsgs, 'Project name is required');
        if (empty($_POST['description'])) array_push($errorMsgs, 'Description is required');
     
        if (!empty($errorMsgs)) {
            $_SESSION['project_errors'] = $errorMsgs;
            return header('Location: /');
        }
        
        $userId = $_SESSION['logged_in_user']->_id;
        $name = htmlentities($_POST['name'], ENT_QUOTES, 'UTF-8');
        $description = htmlentities($_POST['description'], ENT_QUOTES, 'UTF-8');
        $completed = isset($_POST['completed']);

        $newProject = Fauna::createNewProject($userId, $name, $description, $completed);

        if (gettype($newProject) == 'string') {
            array_push($errorMsgs, 'Something went wrong');
            $_SESSION['project_errors'] = $errorMsgs;
            return header('Location: /register');
        }

        return header('Location: /');        
    }

    // update a project
    public function update() {
        $errorMsgs = array();
        if (empty($_POST['name'])) array_push($errorMsgs, 'Project name is required');
        if (empty($_POST['description'])) array_push($errorMsgs, 'Description is required');
     
        $projectId = htmlentities($_POST['project_id'], ENT_QUOTES, 'UTF-8');

        if (!empty($errorMsgs)) {
            $_SESSION['project_errors'] = $errorMsgs;
            return header('Location: /edit/'.$projectId);
        }
        
        $name = htmlentities($_POST['name'], ENT_QUOTES, 'UTF-8');
        $description = htmlentities($_POST['description'], ENT_QUOTES, 'UTF-8');
        $completed = isset($_POST['completed']);

        $newProject = Fauna::updateExistingProject($projectId, $name, $description, $completed);

        if (gettype($newProject) == 'string') {
            array_push($errorMsgs, 'Something went wrong');
            $_SESSION['project_errors'] = $errorMsgs;
            return header('Location: /');
        }

        return header('Location: /');        
    }

    // delete a project
    public function delete() {
        $errorMsgs = array();     
        $projectId = htmlentities($_POST['project_id'], ENT_QUOTES, 'UTF-8');

        $newProject = Fauna::deleteExistingProject($projectId);

        if (gettype($newProject) == 'string') {
            array_push($errorMsgs, 'Something went wrong');
            $_SESSION['project_errors'] = $errorMsgs;
            return header('Location: /');
        }

        return header('Location: /');        
    }
    
}