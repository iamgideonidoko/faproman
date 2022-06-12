<?php
if (!isset($_SESSION['logged_in_user'])) {
    header('Location: /login');
}
$loggedInUser = $_SESSION['logged_in_user'];

if (isset($_SESSION['project_errors'])) {
    $projectErrors = $_SESSION['project_errors'];
    unset($_SESSION['project_errors']);
}

var_dump($loggedInUser);
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
            <input type="text" required class="form-control" id="floatingInput" name="name" placeholder="Name of project">
            <label for="name">Project Name</label>
        </div>
        <div class="form-floating">
            <textarea required class="form-control" placeholder="Enter project description here..." name="description" id="description"
                style="height: 100px"></textarea>
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
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    Accordion Item #1
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse
                    plugin adds the appropriate classes that we use to style each element. These classes control the
                    overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of
                    this with custom CSS or overriding our default variables. It's also worth noting that just about any
                    HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                </div>
                <div class="border m-2 p-2 d-flex justify-content-between align-items-center">
                    <div>Completed: <strong>Yes</strong></div>
                    <div>
                        <a href="#" class="btn btn-outline-danger border-0 py-0 px-1"><i class="bi bi-trash"></i></a>
                        <a href="#" class="btn btn-outline-danger border-0 py-0 px-1"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Accordion Item #2
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>This is the second item's accordion body.</strong> It is hidden by default, until the
                    collapse plugin adds the appropriate classes that we use to style each element. These classes
                    control the overall appearance, as well as the showing and hiding via CSS transitions. You can
                    modify any of this with custom CSS or overriding our default variables. It's also worth noting that
                    just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit
                    overflow.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Accordion Item #3
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <strong>This is the third item's accordion body.</strong> It is hidden by default, until the
                    collapse plugin adds the appropriate classes that we use to style each element. These classes
                    control the overall appearance, as well as the showing and hiding via CSS transitions. You can
                    modify any of this with custom CSS or overriding our default variables. It's also worth noting that
                    just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit
                    overflow.
                </div>
            </div>
        </div>
    </div>
</div>