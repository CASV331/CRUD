<?php

namespace app\controllers;

use app\models\mainModel;

class loginController extends mainModel
{

    // Controlador inicio de sesion
    public function iniciarSesionControlador()
    {
        // Almacenar datos en variables
        $usuario = $this->limpiarCadena($_POST['login_usuario']);
        $password = $this->limpiarCadena($_POST['password_usuario']);

        // Verificando campos obligatorios
        if ($usuario == "" || $password == "") {
            echo "
            <script>
                Swal.fire({
                    icon: 'info',
                    tittle: 'Atencion',
                    text: 'Por favor, llena los campos con tu informacion',
                    confirmButtonText: 'Aceptar'
                })
            </script>
            ";
        } else {
            // Verificar la integridad de los datos
            if ($this->verificarDatos("[a-zA-Z0-9]{4,20}", $usuario)) {
                echo "
                <script>
                    Swal.fire({
                        icon: 'info',
                        tittle: 'Atencion',
                        text: 'El usuario ingresado no coincide con el formato adecuado',
                        confirmButtonText: 'Aceptar'
                    })
                </script>
                ";
            } else {
                if ($this->verificarDatos("[a-zA-Z0-9$@.\-]{7,20}", $password)) {
                    echo "
                    <script>
                        Swal.fire({
                            icon: 'info',
                            tittle: 'Atencion',
                            text: 'La contraseña ingresada no coincide con el formato adecuado',
                            confirmButtonText: 'Aceptar'
                        })
                    </script>
                    ";
                } else {
                    //VERFIFICANDO USUARIO
                    $checkUsuario = $this->ejecutarConsulta("SELECT * FROM usuario WHERE usuario_usuario = '$usuario'");

                    if ($checkUsuario->rowCount() == 1) {
                        $checkUsuario = $checkUsuario->fetch();

                        if ($checkUsuario['usuario_usuario'] == $usuario && password_verify($password, $checkUsuario['usuario_password'])) {
                            $_SESSION['id'] = $checkUsuario['usuario_id'];
                            $_SESSION['nombre'] = $checkUsuario['usuario_nombre'];
                            $_SESSION['apellido'] = $checkUsuario['usuario_apellido'];
                            $_SESSION['usuario'] = $checkUsuario['usuario_usuario'];
                            $_SESSION['foto'] = $checkUsuario['usuario_foto'];

                            if (headers_sent()) {
                                echo
                                "<script>
                                window.loaction.href='" . APP_URL . "dashboard/'
                                </script>";
                            } else {
                                header("Location: " . APP_URL . "dashboard/");
                            }
                        } else {
                            echo "
                        <script>
                            Swal.fire({
                                icon: 'info',
                                tittle: 'Atencion',
                                text: 'Usuario o clave incorrectos',
                                confirmButtonText: 'Aceptar'
                            })
                        </script>
                        ";
                        }
                    } else {
                        echo "
                        <script>
                            Swal.fire({
                                icon: 'info',
                                tittle: 'Atencion',
                                text: 'Usuario o clave incorrectos',
                                confirmButtonText: 'Aceptar'
                            })
                        </script>
                        ";
                    }
                }
            }
        }
    }

    // Controlador de cierre de sesion
    public function cerrarSesionControlador()
    {

        session_destroy();
        if (headers_sent()) {
            echo
            "<script>
            window.location.href='" . APP_URL . "login/'; 
            </script>";
        } else {
            header("Location: " . APP_URL . "login/");
        }
    }
}
