<div class="container d-flex justify-content-center align-items-center vh-100">
    <form class="border p-4 rounded shadow-lg w-100" style="max-width: 400px;" action="" method="POST" autocomplete="off">
        <h5 class="text-center text-uppercase fw-bold mb-4">Inicio de sesion</h5>

        <!--Campo de usuario -->
        <div class="mb-3">
            <label for="usuario">Usuario</label>
            <input class="form-control" type="text" id="usuario" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
        </div>

        <!--Campo de password -->
        <div>
            <label for="clave">Clave</label>
            <input class="form-control" type="password" id="clave" name="password_usuario" pattern="[a-zA-Z0-9$@.\-]{7,20}" maxlength="100" required>
        </div>

        <!-- Boton de envio -->
        <div class="d-flex justify-content-center mt-4">
            <button type="submit" class="btn btn-rojo rounded">Iniciar sesion</button>
        </div>
    </form>
</div>
<?php
if (isset($_POST['login_usuario']) && isset($_POST['password_usuario'])) {
    $insLogin->iniciarSesionControlador();
}
