<?php

namespace app\controllers;

use app\models\mainModel;

class userController extends mainModel
{

    #Controlador de registro de usuario#
    public function registrarUsuarioControlador()
    {

        // Almacenando datos
        $nombre = $this->limpiarCadena($_POST['usuario_nombre']);
        $apellido = $this->limpiarCadena($_POST['usuario_apellido']);
        $usuario = $this->limpiarCadena($_POST['usuario_usuario']);
        $password1 = $this->limpiarCadena($_POST['usuario_password_1']);
        $password2 = $this->limpiarCadena($_POST['usuario_password_2']);


        // Verificando campos obligatorios
        if (empty($nombre) || empty($apellido) || empty($usuario) || empty($password1) || empty($password2)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "Todos los campos son obligatorios",
                "icon" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verfificar la integridad de los datos
        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "El campo nombre contiene caracteres no validos",
                "icon" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "El campo apellido contiene caracteres no validos",
                "icon" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $usuario)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "El campo usuario contiene caracteres no validos",
                "icon" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        if (
            $this->verificarDatos("[a-zA-Z0-9!@#$%&*]{3,40}", $password1) ||
            $this->verificarDatos("[a-zA-Z0-9!@#$%&*]{3,40}", $password2)
        ) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "Los campos clave contienen caracteres no validos",
                "icon" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        // Verificar Email
        #if($email != ''){
        #   if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        #$checkEmail=$this->ejecutarConsulta("SELECT cliente_correo from clientes WHERE cliente_correo = '$email'");
        #if($checkEmail->rowCount() > 0){
        #$alerta = [
        #        "tipo" => "simple",
        #      "titulo" => "Error",
        #     "texto" => "El correo ya existe en el sistema",
        #    "icon" => "error"
        #];
        #return json_encode($alerta);
        #exit();

        #}
        #  }else{
        #     $alerta = [
        #        "tipo" => "simple",
        #      "titulo" => "Error",
        #     "texto" => "El correo no es valido",
        #    "icon" => "error"
        #];
        #return json_encode($alerta);
        #exit();
        #}
        #}
        // VERIFICANDO CLAVES
        if ($password1 != $password2) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "Las contraseñas no coinciden",
                "icon" => "error"
            ];
            return json_encode($alerta);
            exit();
        } else {
            $password = password_hash($password1, PASSWORD_BCRYPT, ["cost" => 10]);
        }

        //VERFIFICANDO USUARIO
        $checkUsuario = $this->ejecutarConsulta("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$usuario'");
        if ($checkUsuario->rowCount() > 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "El usuario ingresado ya se encuentra registrado",
                "icon" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        # Directorio de imagenes #
        $imgDir = "../views/photos/";

        #Comprobar si se selecciono una imagen
        if ($_FILES['usuario_foto']['name'] != "" && $_FILES['usuario_foto']['size'] > 0) {

            // Creando directorio
            if (!file_exists($imgDir)) {
                if (!mkdir($imgDir, 0775)) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Error al subir el archivo",
                        "texto" => "Error al crear el directorio",
                        "icon" => "error"
                    ];
                    return json_encode($alerta);
                    exit();
                }
            }

            // Verificando formato de las imagenes
            if (mime_content_type($_FILES['usuario_foto']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['usuario_foto']['tmp_name']) != "image/png") {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error al subir el archivo",
                    "texto" => "La imagen debe ser de formato jpeg/png",
                    "icon" => "error"
                ];
                return json_encode($alerta);
                exit();
            }

            if (($_FILES['usuario_foto']['size'] / 1024) > 5120) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error al subir el archivo",
                    "texto" => "El tamaño de la imagen debe ser menor a 5MB",
                    "icon" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
            //Nombre de la foto
            $foto = str_ireplace(" ", "_", $nombre . "_" . $apellido);
            $foto = $foto . "_" . rand(0, 100);

            //Extension de la imagen
            switch (mime_content_type($_FILES['usuario_foto']['tmp_name'])) {
                case "image/jpeg":
                    $foto = $foto . ".jpeg";
                    break;
                case "image/png":
                    $foto = $foto . ".png";
                    break;
            }
            chmod($imgDir, 0775);

            //moviendo la imagen al directorio
            if (!move_uploaded_file($_FILES['usuario_foto']['tmp_name'], $imgDir . $foto)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Error al subir el archivo",
                    "texto" => "En este momento no podemos subir la imagen",
                    "icon" => "error"
                ];
                return json_encode($alerta);
                exit();
            }
        } else {
            $foto = "";
        }
        $usuario_datos_reg = [
            [
                "campo_nombre" => "usuario_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre
            ],
            [
                "campo_nombre" => "usuario_apellido",
                "campo_marcador" => ":Apellido",
                "campo_valor" => $apellido
            ],
            [
                "campo_nombre" => "usuario_usuario",
                "campo_marcador" => ":Usuario",
                "campo_valor" => $usuario
            ],
            [
                "campo_nombre" => "usuario_password",
                "campo_marcador" => ":Password",
                "campo_valor" => $password
            ],
            [
                "campo_nombre" => "usuario_foto",
                "campo_marcador" => ":Foto",
                "campo_valor" => $foto
            ],
            [
                "campo_nombre" => "usuario_creado",
                "campo_marcador" => ":Creado",
                "campo_valor" => date("Y/m/d H:i")
            ],
            [
                "campo_nombre" => "usuario_actualizado",
                "campo_marcador" => ":Actualizado",
                "campo_valor" => date("Y/m/d H:i")
            ],
            [
                "campo_nombre" => "usuario_borrado",
                "campo_marcador" => ":Borrado",
                "campo_valor" => 0
            ]
        ];
        $registrarUsuario = $this->guardarDatos("usuario", $usuario_datos_reg);
        if ($registrarUsuario->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Operacion realizada con exito",
                "texto" => "Usuario " . $nombre . " " . $apellido . " registrado correctamente",
                "icon" => "success"
            ];
        } else {

            if (is_file($imgDir . $foto)) {
                chmod($imgDir . $foto, 0775);
                unlink($imgDir . $foto);
            }
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error al registrar el usuario",
                "texto" => "No fue posible registrar el usuario, intente nuevamente",
                "icon" => "error"
            ];
        }
        return json_encode($alerta);
    }

    // Controlador para listar usuarios
    public function listarUsuarioControlador($pagina, $registros, $url, $busqueda)
    {
        $pagina = $this->limpiarCadena($pagina);
        $registros = $this->limpiarCadena($registros);
        $url = $this->limpiarCadena($url);
        $url = APP_URL . $url . "/";
        $busqueda = $this->limpiarCadena($busqueda);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if (isset($busqueda) && $busqueda != "") {
            $consulta_datos = "SELECT * FROM usuario WHERE ((usuario_id!='" . $_SESSION['id'] . "' AND usuario_id != '1') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%')) ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

            $consulta_total = "SELECT COUNT(usuario_id) FROM usuario WHERE ((usuario_id!='" . $_SESSION['id'] . "' AND usuario_id != '1') AND (usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%'))";
        } else {
            $consulta_datos = "SELECT * FROM usuario WHERE usuario_id!='" . $_SESSION['id'] . "' AND usuario_id != '1' ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

            $consulta_total = "SELECT COUNT(usuario_id) FROM usuario WHERE usuario_id!='" . $_SESSION['id'] . "' AND usuario_id != '1'";
        }

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total_datos = $this->ejecutarConsulta($consulta_total);
        $total_datos = (int) $total_datos->fetchColumn();

        $numPaginas = ceil($total_datos / $registros);

        $tabla .=
            '
         <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Usuario</th>
                        <th>Creado</th>
                        <th>Actualizado</th>
                        <th colspan="3">Opciones</th>
                    </tr>
                </thead>
            <tbody class="text-center">
        ';
        if ($total_datos >= 1 && $pagina <= $numPaginas) {
            $contador = $inicio + 1;
            $pag_inicio = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .=
                    '
                <tr>
                    <td>' . $contador . '</td>
                    <td>' . $rows['usuario_nombre'] . '</td>
                    <td>' . $rows['usuario_apellido'] . '</td>
                    <td>' . $rows['usuario_usuario'] . '</td>
                    <td>' . date("d-m-Y h:i A", strtotime($rows['usuario_creado'])) . '</td>
                    <td>' . date("d-m-Y h:i A", strtotime($rows['usuario_actualizado'])) . '</td>
                    <td>
                        <a href="' . APP_URL . 'userPhoto/' . $rows['usuario_id'] . '/" class="btn btn-info btn-sm rounded-pill">Foto</a>
                    </td>
                    <td>
                        <a href="' . APP_URL . 'userUpdate/' . $rows['usuario_id'] . '/" class="btn btn-success btn-sm rounded-pill">Actualizar</a>
                    </td>
                    <td>
                        <form class="formularioAjax" action="' . APP_URL . 'app/ajax/usuarioAjax.php" method="POST" autocomplete="off">
                            <input type="hidden" name="modulo_usuario" value="eliminar">
                            <input type="hidden" name="usuario_id" value="' . $rows['usuario_id'] . '">
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill">Eliminar</button>
                        </form>
                    </td>
                </tr>
                ';
                $contador++;
            }
            $pag_final = $contador - 1;
        } else {
            if ($total_datos >= 1) {
                $tabla .=
                    '
                <tr>
                    <td colspan="7">
                        <a href="' . $url . '1/" class="btn btn-link btn-sm mt-3 mb-3">
                            Haga clic aqui para recargar el listado
                        </a>
                    </td>
                </tr>
                ';
            } else {
                $tabla .=
                    '
                 <tr>
                    <td colspan="7">
                        No hay registros en el sistema
                    </td>
                </tr>
                ';
            }
        }
        $tabla .= '</tbody></table></div>';

        if ($total_datos >= 1 && $pagina <= $numPaginas) {
            $tabla .=
                '
            <p class="text-end">Mostrando usuarios <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total_datos . '</strong></p>
            ';
            $tabla .= $this->paginacion($pagina, $numPaginas, $url, 10);
        }
        return $tabla;
    }

    // Controlador para eliminar usuarios
    public function eliminarUsuarioControlador()
    {
        $id = $this->limpiarCadena($_POST['usuario_id']);

        if ($id == 1) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "No podemos eliminar el usuario principal del sistema",
                "icon" => "error"
            ];
        }
        // Verficar el usuario
        $datos = $this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_id = '$id'");

        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "No se encontro usuario en el sistema",
                "icon" => "error"
            ];
        } else {
            $datos = $datos->fetch();
        }

        $elimnarUsuario = $this->eliminarRegistro("usuario", "usuario_id", $id);
        if ($elimnarUsuario->rowCount() == 1) {

            if (is_file("../views/photos/" . $datos['usuario_foto'])) {
                chmod("../views/photos/" . $datos['usuario_foto'], 0775);
                unlink("../views/photos/" . $datos['usuario_foto']);
            }
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Usuario eliminado",
                "texto" => "El usuario " . $datos['usuario_nombre'] . " " . $datos['usuario_apellido'] . " ha sido eliminado",
                "icon" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "No fue posible eliminar el usuario " . $datos['usuario_nombre'] . " " . $datos['apellido'],
                "icon" => "error"
            ];
        }
        return json_encode($alerta);
    }
}
