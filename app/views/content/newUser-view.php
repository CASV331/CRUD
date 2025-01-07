<?php
if ($_SESSION['id'] != 1) {
    header('Location:' . APP_URL . 'dashboard/');
}
?>
<div class="container mb-6">
    <h1 class="display-4 fw-4">Usuarios</h1>
    <h2 class="h5 text-muted">Nuevo usuario</h2>
</div>

<div class="container py-5">

    <form class="formularioAjax" action="<?php echo APP_URL; ?>app/ajax/usuarioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">

        <input type="hidden" name="modulo_usuario" value="registrar">

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="usuario_nombre" class="form-label">Nombres</label>
                    <input type="text" id="usuario_nombre" class="form-control" name="usuario_nombre"
                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="usuario_apellido" class="form-label">Apellidos</label>
                    <input type="text" id="usuario_apellido" class="form-control" name="usuario_apellido"
                        pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="usuario_usuario" class="form-label">Usuario</label>
                    <input type="text" id="usuario_usuario" class="form-control" name="usuario_usuario"
                        pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="usuario_password_1" class="form-label">Clave</label>
                    <input type="password" id="usuario_password_1" class="form-control" name="usuario_password_1"
                        pattern="[a-zA-Z0-9$@.\-]{6,20}" maxlength="20" required>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="usuario_foto" class="form-label">Foto</label>
                    <input type="file" id="usuario_foto" class="form-control" name="usuario_foto"
                        accept=".jpg, .png, .jpeg">
                    <small class="form-text text-muted">JPG, JPEG, PNG. (MAX 5MB)</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="usuario_password_2" class="form-label">Repetir clave</label>
                    <input type="password" id="usuario_password_2" class="form-control" name="usuario_password_2"
                        pattern="[a-zA-Z0-9$@.\-]{6,20}" maxlength="20" required>
                </div>
            </div>
        </div>

        <div class="row mb-3">
        </div>

        <div class="text-center">
            <button type="reset" class="btn btn-outline-secondary rounded">Limpiar</button>
            <button type="submit" class="btn btn-primary rounded btn-rojo">Guardar</button>
        </div>

    </form>
</div>