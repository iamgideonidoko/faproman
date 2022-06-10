<?php
if (!isset($_SESSION['is_logged_in'])) {
    header('Location: /login');
}
?>

<div class="container my-3">
    <h1>Home page</h1>
</div>