<?php
use \App\Lib\Fauna;

if (!isset($_SESSION['logged_in_user'])) {
    header('Location: /login');
}
$loggedInUser = $_SESSION['logged_in_user'];

if (isset($_SESSION['project_errors'])) {
    $projectErrors = $_SESSION['project_errors'];
    unset($_SESSION['project_errors']);
}

$userProjects = Fauna::getProjectsByUser($loggedInUser->_id);
?>

<div class="container my-3">
    <h2 class="mt-5">Welcome @<?php echo $loggedInUser->username ?></h2>
    <p>Manage your projects here.</p>
    <form method="post" action="/project/create" class="text-start mt-3">
        <?php
        if (isset($projectErrors) && !empty($projectErrors)) {
        ?>
        <div class="form-error-box">
            <?php
                foreach ($projectErrors as $value) {
                    echo $value . '<br>';
                } 
                ?>
        </div>
        <?php
        }
        ?>
        <div class="form-floating mb-3">
            <input type="text" required class="form-control" id="floatingInput" name="name"
                placeholder="Name of project">
            <label for="name">Project Name</label>
        </div>
        <div class="form-floating">
            <textarea required class="form-control" placeholder="Enter project description here..." name="description"
                id="description" style="height: 100px"></textarea>
            <label for="description">Description</label>
        </div>
        <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" name="completed" id="completed">
            <label class="form-check-label" for="completed">
                Completed
            </label>
        </div>
        <button type="submit" class="btn text-white bg-dark mt-3">Add Project</button>
    </form>

    <h4 class="mt-5">All Your Projects</h4>
    <div class="accordion mt-3" id="accordionExample">
        <?php 
        if (gettype($userProjects) == "array"):
            for ($i = 0; $i < count($userProjects); $i++): 
            $project = $userProjects[$i];
        ?>
        <div class="accordion-item">
            <h2 class="accordion-header"  id="headingOne<?php echo $i; ?>">
                <button class="accordion-button <?php echo $i != 0 ? "collapsed" : null; ?>" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse<?php echo $i; ?>" aria-expanded="true"
                    aria-controls="collapse<?php echo $i; ?>">
                    <?php echo $project->name; ?>
                </button>
            </h2>
            <div id="collapse<?php echo $i; ?>"
                class="accordion-collapse collapse <?php echo $i == 0 ? "show" : null; ?>"
                aria-labelledby="headingOne<?php echo $i; ?>"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <?php echo $project->description; ?>
                </div>
                <div class="border m-2 p-2 d-flex justify-content-between align-items-center">
                    <div>Completed: <strong><?php echo $project->completed ? "Yes" : "No" ?></strong></div>
                    <div>
                        <a href="#" class="btn btn-outline-danger border-0 py-0 px-1"><i class="bi bi-trash"></i></a>
                        <a href="#" class="btn btn-outline-danger border-0 py-0 px-1"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            endfor;
        endif;
        ?>
    </div>
</div>