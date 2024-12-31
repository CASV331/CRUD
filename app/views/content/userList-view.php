<div class="container my-4">
    <h1 class="display-5">Usuarios</h1>
    <h2 class="lead">Lista de usuarios</h2>
</div>
<div class="container py-4">
    <?php

    use app\controllers\userController;

    $instUsuario = new userController();
    echo $instUsuario->listarUsuarioControlador($url[1], 10, $url[0], "");
    ?>
    <nav aria-label="Page navigation" class="d-flex justify-content-center">
        <ul class="pagination pagination-rounded">
            <li class="page-item disabled">
                <a class="page-link">Anterior</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item disabled">
                <a class="page-link">Siguiente</a>
            </li>
        </ul>
    </nav>

</div>