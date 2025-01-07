<nav class="navbar  navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo APP_URL; ?>dashboard/">
            <img src="<?php echo APP_URL; ?>/app/views/img/thermos-logo.svg" alt="Logo Thermos" width="auto" height="30">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav">
            <ul class="d-flex flex-md-row gap-3 navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="<?php echo APP_URL; ?>dashboard/">Home</a>
                </li>
                <li class="nav-item">
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="">Clientes</a>
                </li>
                <div class="dropdown <?php echo $_SESSION['id'] == 1 ?  '' : 'd-none' ?>">
                    <a class="btn btn-secondary btnDrop dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Usuarios
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>newUser/">Nuevo</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>userList/">Lista</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>userSearch/">Buscar</a></li>
                    </ul>
                </div>
                <div class="dropdown me-2">
                    <a class="btn btn-secondary btnDrop dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Perfil
                    </a>
                    <ul class="dropdown-menu dm-menu">

                        <li><a class="dropdown-item" href="<?php echo APP_URL . "userUpdate/" . $_SESSION['id'] . "/"; ?>">Mi cuenta</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL . "userPhoto/" . $_SESSION['id'] . "/"; ?>">Mi foto</a></li>
                        <li><a class="dropdown-item" href="<?php echo APP_URL; ?>logOut/" id="btn_exit">Cerrar sesion</a></li>
                    </ul>
                </div>
            </ul>
            <!--<form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>-->

        </div>
    </div>
</nav>