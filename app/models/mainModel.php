<?php

namespace app\models;

use \PDO;
use PDOException;

if (file_exists(__DIR__ . "/../../config/server.php")) {
    require_once __DIR__ . "/../../config/server.php";
}

class mainModel
{
    private $server = DB_SERVER;
    private $db = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;

    protected function conectar()
    {
        $conexion = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->db, $this->user, $this->pass);
        $conexion->exec("SET CHARACTER SET utf8");
        return $conexion;
    }

    protected function ejecutarConsulta($consulta)
    {
        $sql = $this->conectar()->prepare($consulta);
        $sql->execute();
        return $sql;
    }

    public function limpiarCadena($cadena)
    {
        $palabras = ["<script>", "</script>", "<script src", "<script type=", "SELECT * FROM", "DELETE FROM", "INSERT INTO", "DROP TABLE", "DROP DATABASE", "TRUNCATE TABLE", "SHOW TABLES", "SHOW DATABASES", "<?php", "?>", "--", "^", "<", ">", "==", "=", ";", "::"];

        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);

        foreach ($palabras as $palabra) {
            $cadena = str_ireplace($palabra, "", $cadena);
        }
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        return $cadena;
    }

    protected function verificarDatos($filtro, $cadena)
    {
        if (preg_match("/^" . $filtro . "$/", $cadena)) {
            return false;
        } else {
            return true;
        }
    }

    protected function guardarDatos($tabla, $datos)
    {
        $query = "INSERT INTO $tabla (";

        $c = 0;
        foreach ($datos as $dato) {
            if ($c >= 1) {
                $query .= ",";
            }
            $query .= $dato['campo_nombre'];
            $c++;
        }
        $query .= ") VALUES(";

        $c = 0;
        foreach ($datos as $dato) {
            if ($c >= 1) {
                $query .= ",";
            }
            $query .= $dato['campo_marcador'];
            $c++;
        }
        $query .= ")";
        $sql = $this->conectar()->prepare($query);
        foreach ($datos as $dato) {
            $sql->bindParam($dato['campo_marcador'], $dato['campo_valor']);
        }
        $sql->execute();
        return $sql;
    }

    public function seleccionarDatos($tipo, $tabla, $campo, $id)
    {
        $tipo = $this->limpiarCadena($tipo);
        $tabla = $this->limpiarCadena($tabla);
        $campo = $this->limpiarCadena($campo);
        $id = $this->limpiarCadena($id);

        if ($tipo == "Unico") {
            $sql = $this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "Normal") {
            $sql = $this->conectar()->prepare("SELECT $campo FROM $tabla");
        }
        $sql->execute();

        return $sql;
    }

    protected function actualizarDatos($tabla, $datos, $condicion)
    {
        $query = "UPDATE $tabla SET ";
        $c = 0;
        foreach ($datos as $dato) {
            if ($c >= 1) {
                $query .= ", ";
            }
            $query .= $dato['campo_nombre'] . " = " . $dato['campo_marcador'];
            $c++;
        }
        $query .= "WHERE " . $condicion["condicion_campo"] . " = " . $condicion["condicion_marcador"];

        $sql = $this->conectar()->prepare($query);

        foreach ($datos as $dato) {
            $sql->bindParam($dato["campo_marcador"], $dato["campo_valor"]);
        }

        $sql->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);
        $sql->execute();
        return $sql;
    }

    protected function eliminarRegistro($tabla, $campo, $id)
    {
        $sql = $this->conectar()->prepare("DELETE FROM $tabla WHERE $campo=:id");
        $sql->bindParam(":id", $id);
        $sql->execute();

        return $sql;
    }

    protected function paginacion($pagina, $numeroPag, $url, $btns)
    {

        $tabla = '<nav aria-label="Page navigation">';
        if ($pagina <= 1) {
            $tabla .= '
            <!--Boton anterior deshabilitado-->
            <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
            </li>
            <ul class="pagination justify-content-center">
            ';
        } else {
            $tabla .= '
            <!--Boton anterior habilitado-->
            <li class="page-item">
            <a class="page-link" href="' . $url . ($pagina - 1) . '/">Anterior</a>
            </li>
            <ul class="pagination justify-content-center">

            <!--Paginas enumeradas-->
            <li class="page-item">
            <a class="page-link" href="' . $url . '1/' . '">1</a>
            </li>

            <!--Elipsis-->
            <li class="page-item disabled">
            <span class="page-link">…</span> <!-- Elipsis -->
            </li>
            ';
        }
        $contador = 0;
        for ($i = $pagina; $i <= $numeroPag; $i++) {

            if ($contador >= $btns) {
                break;
            }
            if ($pagina == $i) {
                $tabla .= '
                <li class="page-item active" aria-current="page">
                <a class="page-link" href="' . $url . $i . '/">' . $i . '</a>
                </li>';
            } else {
                $tabla .= '
                <li class="page-item " aria-current="page">
                <a class="page-link" href="' . $url . $i . '/">' . $i . '</a>
                </li>';
            }
            $contador++;
        }
        if ($pagina = $numeroPag) {
            $tabla .= '
            </ul>
            <!--Boton siguiente deshabilitado-->
            <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Siguiente</a>
            </li>
            
            ';
        } else {
            $tabla .= '
            <!--Elipsis-->
            <li class="page-item disabled">
            <span class="page-link">…</span> <!-- Elipsis -->
            </li>
            
            <!--Boton enumerado-->
            <li class="page-item">
            <a class="page-link" href="' . $url . $numeroPag . '/">' . $numeroPag . '</a>
            </li>

            <!--Boton siguiente habilitado-->
            </u>
            <li class="page-item">
            <a class="page-link" href="' . $url . ($pagina + 1) . '/">Siguiente</a>
            </li>
            ';
        }
        $tabla .= '</nav>';
        return $tabla;
    }
}
