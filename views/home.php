<?php
if (!isset($_SESSION['logged_in_user'])) {
    header('Location: /login');
}
$loggedInUser = $_SESSION['logged_in_user'];
var_dump($loggedInUser);

if (isset($_SESSION['ttl'])) {
    echo 'TTL => ', $_SESSION['ttl'];
}
?>

<div class="container my-3">
    <h2>Welcome @<?php echo $loggedInUser->username ?></h2>
    <p>Manage your projects here.</p>
</div>