<?php 
if (isset($_SESSION['login_errors'])) {
    $loginErrors = $_SESSION['login_errors'];
    unset($_SESSION['login_errors']);
}
?>

<div class="container my-5 text-center">
    <h2>Login to Faproman</h1>
        <p>You must login to manage your projects</p>
        <form method="post" action="/user/authenticate" class="text-start mx-auto mt-3" style="max-width: 400px;">
            <?php
            if (isset($loginErrors) && !empty($loginErrors)) {
            ?>
                <div class="form-error-box">
                    <?php
                    foreach ($loginErrors as $value) {
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
            <div class="mb-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" required class="form-control" name="password" id="password">
            </div>
            <div class="form-text text-end mb-4">New? <a href="/register">Sign Up</a></div>
            <button type="submit" class="btn text-white bg-dark d-block w-100">Login</button>
        </form>
</div>