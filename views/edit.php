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

$project = Fauna::getSingleProjectByUser($projectId);
?>

<div class="container my-3">
    <?php if (gettype($project) != 'object'): ?>
    <h2 class="mt-5">Project Not Found</h2>
    <?php else: ?>
    <h2 class="mt-5">Update Project</h2>
    <p>Update your project here.</p>
    <form method="post" action="/project/update" class="text-start mt-3">
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
                placeholder="Name of project" value="<?php echo $project->name ?>">
            <label for="name">Project Name</label>
        </div>
        <div class="form-floating">
            <textarea required class="form-control" placeholder="Enter project description here..." name="description"
                id="description" style="height: 100px"><?php echo $project->description ?></textarea>
            <label for="description">Description</label>
        </div>
        <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" name="completed" id="completed" <?php echo $project?->completed ? "checked" : null ?>>
            <label class="form-check-label" for="completed">
                Completed
            </label>
        </div>
        <input type="hidden"  name="project_id" value="<?php echo $project->_id ?>">
        <button type="submit" class="btn text-white bg-dark mt-3">Edit Project</button>
        <a href="/" class="btn btn-outline-dark mt-3 ms-2">Cancel</a>
    </form>
    <?php endif; ?>
</div>