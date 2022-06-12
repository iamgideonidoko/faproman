<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="/">Faproman</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            </ul>
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['logged_in_user'])) { ?>
                    <span class="text-white me-3"><i class="bi bi-person-circle"></i> <?php echo $_SESSION['logged_in_user']->username ?></span>
                    <a href="/logout" class="btn btn-outline-light">Logout</a>
                <?php } else { ?>
                    <a href="/login" class="btn btn-outline-light">Login</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>