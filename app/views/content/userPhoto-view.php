<div class="container-fluid mb-6">
    <?php
    $id = $insLogin->limpiarCadena($url[1]);

    if ($id == $_SESSION['id']) {
    ?>
        <h1 class="display-4">Mi foto de perfil</h1>
        <h2 class="h5 text-muted">Actualizar foto de perfil</h2>
    <?php } else { ?>
        <h1 class="display-4">Usuarios</h1>
        <h2 class="h5 text-muted">Actualizar foto de perfil</h2>
    <?php } ?>
</div>

<div class="container py-6">
    <?php
    include "./app/views/includes/btn_back.php";

    $datos = $insLogin->seleccionarDatos("Unico", "usuario", "usuario_id", $id);

    if ($datos->rowCount() == 1) {
        $datos = $datos->fetch();

    ?>
        <h2 class="text-center"><?php echo $datos['usuario_nombre'] . " " . $datos['usuario_apellido'] ?></h2>
        <p class="text-center pb-4"><?php echo "<strong>Usuario creado:</strong> " . date("d-m-Y h:i A", strtotime($datos['usuario_creado'])) . " &nbsp <strong>Usuario actualizado:</strong> " . date("d-m-Y h:i A", strtotime($datos['usuario_actualizado'])); ?></p>

        <div class="row">
            <div class="col-md-5 text-center">
                <?php if (is_file("app/views/photos/" . $datos['usuario_foto'])) { ?>
                    <figure class="mb-4">
                        <img class="rounded-circle img-fluid" src="<?php echo APP_URL ?>app/views/photos/<?php echo $datos['usuario_foto'] ?>" alt="Foto de perfil usuario">
                    </figure>

                    <form class="formularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off">

                        <input type="hidden" name="modulo_usuario" value="eliminarFoto">
                        <input type="hidden" name="usuario_id" value="<?php echo $datos['usuario_id'] ?>">

                        <p class="text-center">
                            <button type="submit" class="btn btn-danger rounded-pill">Eliminar foto</button>
                        </p>
                    </form>
                <?php } else { ?>
                    <figure class="mb-4">
                        <img class="rounded-circle img-fluid" src="<?php echo APP_URL ?>app/views/photos/defaultPhoto.svg" alt="Foto de perfil default">
                    </figure>
                <?php } ?>
            </div>

            <div class="col-md-7">
                <form class="mb-6 text-center formularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="modulo_usuario" value="actualizarFoto">
                    <input type="hidden" name="usuario_id" value="<?php echo $datos['usuario_id'] ?>">

                    <label class="form-label">Foto o imagen del usuario</label>
                    <div class="mb-4 d-flex justify-content-center">
                        <div class="input-group">
                            <input class="form-control" type="file" name="usuario_foto" accept=".jpg, .png, .jpeg">
                            <label class="input-group-text">JPG, JPEG, PNG. (MAX 5MB)</label>
                        </div>
                    </div>

                    <p class="text-center">
                        <button type="submit" class="btn btn-success rounded-pill">Actualizar foto</button>
                    </p>
                </form>
            </div>
        </div>

    <?php
    } else {
        include "./app/views/includes/error_alert.php";
    }
    ?>
</div>