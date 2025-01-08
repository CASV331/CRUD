<?php
if ($_SESSION['id'] != 1) {
    header('Location:' . APP_URL . 'dashboard/');
}
?>
<div class="container mb-4">
    <h1 class="display-5">Usuarios</h1>
    <h2 class="h5 text-secondary">Buscar usuarios</h2>
</div>

<div class="container py-4">
    <?php

    use app\controllers\userController;

    $instUsuario = new userController();

    if (!isset($_SESSION[$url[0]]) && empty($_SESSION[$url[0]])) {

    ?>
        <!-- Formulario de búsqueda -->
        <div class="row mb-4">
            <div class="col">
                <form class="formularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off">
                    <input type="hidden" name="modulo_buscador" value="buscar">
                    <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                    <div class="input-group">
                        <input type="text" class="form-control rounded-start" name="txt_buscador" placeholder="¿Qué estas buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" required>
                        <button class="btn btn-primary" type="submit">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
    <?php } else { ?>
        <!-- Formulario para eliminar búsqueda -->
        <div class="row text-center mb-5">
            <div class="col">
                <form class="formularioAjax" action="<?php echo APP_URL; ?>app/ajax/buscadorAjax.php" method="POST" autocomplete="off">
                    <input type="hidden" name="modulo_buscador" value="eliminar">
                    <input type="hidden" name="modulo_url" value="<?php echo $url[0]; ?>">
                    <p>Estas buscando <strong>“<?php echo $_SESSION[$url[0]]; ?>”</strong></p>
                    <button type="submit" class="btn btn-danger rounded-pill mt-3">Eliminar búsqueda</button>
                </form>
            </div>
        </div>
    <?php
        echo $instUsuario->listarUsuarioControlador($url[1], 10, $url[0], $_SESSION[$url[0]]);
    }
    ?>
</div>