<?php

namespace app\controllers;

use app\models\mainModel;

class searchController extends mainModel
{

    #Controlador de busquedas  
    public function modulosBusquedaControlador($modulo)
    {

        $listaModulos = ['userSearch'];

        if (in_array($modulo, $listaModulos)) {
            return false;
        } else {
            return true;
        }
    }

    # Controlador para iniciar busquedas
    public function iniciarBuscadorControlador()
    {

        // Almacenando datos
        $url = $this->limpiarCadena($_POST['modulo_url']);
        $texto = $this->limpiarCadena($_POST['txt_buscador']);

        if ($this->modulosBusquedaControlador($url)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "No es posible procesar la peticion",
                "icon" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        if ($texto == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "Introduce un termino de busqueda",
                "icon" => "error"
            ];
            return json_encode($alerta);
            exit();
        }
        // Verfificar la integridad de los datos
        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $texto)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "El termino de busqueda contiene caracteres no validos",
                "icon" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        $_SESSION[$url] = $texto;

        $alerta = [
            "tipo" => "redireccionar",
            "url" => APP_URL . $url . "/"
        ];
        return json_encode($alerta);
    }

    #Controlador para eliminar la busqueda
    public function eliminarBuscadorControlador()
    {

        // Almacenando datos
        $url = $this->limpiarCadena($_POST['modulo_url']);

        if ($this->modulosBusquedaControlador($url)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error",
                "texto" => "No es posible procesar la peticion",
                "icon" => "error"
            ];
            return json_encode($alerta);
            exit();
        }

        unset($_SESSION[$url]);

        $alerta = [
            "tipo" => "redireccionar",
            "url" => APP_URL . $url . "/"
        ];
        return json_encode($alerta);
    }
}
