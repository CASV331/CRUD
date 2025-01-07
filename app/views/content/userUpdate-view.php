<div class="container-fluid mb-4">
    <?php
    $id = $insLogin->limpiarCadena($url[1]);

    if ($id == $_SESSION['id']) {
    ?>
        <h1 class="display-4">Mi cuenta</h1>
        <h2 class="h5">Actualizar cuenta</h2>
    <?php   } else { ?>
        <h1 class="display-4">Usuarios</h1>
        <h2 class="h5">Actualizar usuario</h2>
    <?php } ?>
</div>

<div class="container py-4">
    <?php
    include "./app/views/includes/btn_back.php";

    $datos = $insLogin->seleccionarDatos("Unico", "usuario", "usuario_id", $id);

    if ($datos->rowCount() == 1) {
        $datos = $datos->fetch();
    ?>

        <h2 class="text-center"><?php echo $datos['usuario_nombre'] . " " . $datos['usuario_apellido'] ?></h2>
        <p class="text-center pb-4"><?php echo "<strong>Usuario creado:</strong> " . date("d-m-Y h:i A", strtotime($datos['usuario_creado'])) . " &nbsp <strong>Usuario actualizado:</strong> " . date("d-m-Y h:i A", strtotime($datos['usuario_actualizado'])); ?></p>

        <form class="formularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off">
            <input type="hidden" name="modulo_usuario" value="actualizar">
            <input type="hidden" name="usuario_id" value="<?php echo $datos['usuario_id'] ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="usuario_nombre" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="usuario_nombre" name="usuario_nombre" value="<?php echo $datos['usuario_nombre'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="usuario_apellido" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="usuario_apellido" name="usuario_apellido" value="<?php echo $datos['usuario_apellido'] ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="usuario_usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario_usuario" name="usuario_usuario" value="<?php echo $datos['usuario_usuario'] ?>" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <p class="text-center mt-4 fw-bold">
                            Si desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.
                        </p>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="usuario_password_1" class="form-label">Nueva clave</label>
                        <input type="password" class="form-control" id="usuario_password_1" name="usuario_password_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="usuario_password_2" class="form-label">Repetir nueva clave</label>
                        <input type="password" class="form-control" id="usuario_password_2" name="usuario_password_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
                    </div>
                </div>
            </div>

            <p class="text-center fw-bold">
                Para poder actualizar los datos de este usuario por favor ingrese su USUARIO y CLAVE con la que ha iniciado sesión
            </p>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="administrador_usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="administrador_usuario" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="administrador_clave" class="form-label">Clave</label>
                        <input type="password" class="form-control" id="administrador_clave" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                    </div>
                </div>
            </div>

            <p class="text-center">
                <button type="submit" class="btn btn-success rounded-pill">Actualizar</button>
            </p>
        </form>
    <?php } else {
        include "./app/views/includes/error_alert.php";
    }
    ?>
</div>