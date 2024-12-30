<div class="container is-fluid">
    <h1 class="text-uppercase fw-bolder">Inicio</h1>
    <div class="columns d-flex justify-content-center">
        <figure class="text-center">
            <?php
            if (is_file("./app/views/photos/" . $_SESSION['foto'])) {
                echo '<img class="mx-auto d-block" src="' . APP_URL . 'app/views/photos/' . $_SESSION['foto'] . '">';
            } else {
                echo '<img class="mx-auto d-block" src="' . APP_URL . 'app/views/photos/defaultPhoto.svg">';
            }
            ?>

        </figure>
    </div>
    <div class="columns d-flex justify-content-center">
        <h2 class="fw-light">¡Bienvenido <?php echo $_SESSION['nombre'] . " " . $_SESSION['apellido']; ?>!</h2>
    </div>
</div>