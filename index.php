<?php
require_once "./config/app.php";
require_once "./autoload.php";
require_once "./app/views/includes/session_start.php";

if (isset($_GET['views'])) {
    $url = explode("/", $_GET['views']);
} else {
    $url = ["login"];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php require_once "./app/views/includes/head.php"; ?>
</head>

<body>
    <?php

    use app\controllers\viewsControllers;
    use app\controllers\loginController;

    $insLogin = new loginController();

    $viewsController = new viewsControllers();
    $vista = $viewsController->obtenerVistasControlador($url[0]);

    if ($vista == "login" || $vista == "404") {
        require_once "./app/views/content/" . $vista . "-view.php";
    } else {
        // Cerrar sesion
        if (!isset($_SESSION['id']) || !isset($_SESSION['nombre']) || !isset($_SESSION['usuario']) || $_SESSION['id'] == '' || $_SESSION['usuario'] == '' || $_SESSION['nombre'] == '') {
            $insLogin->cerrarSesionControlador();
            exit;
        }

        require_once "./app/views/includes/navbar.php";
        require_once $vista;
    }
    require_once "./app/views/includes/script.php";
    ?>
</body>

</html>