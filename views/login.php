<?php
use Webmozart\Assert\Assert;
?>
<div class="container my-5 text-center">
    <h2>Login to Faproman</h1>
        <p>You must login to manage your projects</p>
        <?php 
        
        try {
            echo Assert::string('10', 'No be you go tell me wetin I go');
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        ?>

        <form class="text-start mx-auto mt-3" style="max-width: 400px;">
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