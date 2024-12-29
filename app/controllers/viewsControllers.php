<?php

namespace app\controllers;

use app\models\viewsModel;

class viewsControllers extends viewsModel
{
    public function obtenerVistasControlador($vista)
    {
        if ($vista != "") {
            $respuesta = $this->obtenerVistasModelo($vista);
        } else {
            $respuesta = "login";
        }
        return $respuesta;
    }
}
