<?php 
if (isset($_SESSION['register_errors'])) {
    $regErrors = $_SESSION['register_errors'];
    unset($_SESSION['register_errors']);
}
if (isset($_SESSION['logged_in_user'])) {
    header('Location: /');
}
?>

<div class="container my-5 text-center">
    <h2>Sign Up to Faproman</h1>
        <p>Sign up a new Faproman account</p>


        <form class="text-start mx-auto mt-3" method="post" action="/user/create" style="max-width: 400px;">
            <?php
            if (isset($regErrors) && !empty($regErrors)) {
            ?>
                <div class="form-error-box">
                    <?php
                    foreach ($regErrors as $value) {
                        echo $value . '<br>';
                    } 
                    ?>
                </div>
            <?php
            }
            ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" required class="form-control" name="username" id="username">
            </div>
            <div class="mb-3">
                <label for="password1" class="form-label">Password</label>
                <input type="password" required class="form-control" name="password1" id="password1">
            </div>
            <div class="mb-2">
                <label for="password2" class="form-label">Repeat Passord</label>
                <input type="password" required class="form-control" name="password2" id="password2">
            </div>
            <div class="form-text text-end mb-4">Have an account? <a href="/login">Login</a></div>
            <button type="submit" class="btn text-white bg-dark d-block w-100">Sign Up</button>
        </form>
</div>