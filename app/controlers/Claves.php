<?php


class Claves extends Controlador
{



    public function __construct()
    {
        $this->ClavesModelo = $this->modelo('ModeloClaves');
        
    }


    public function plataforma()
    {
       
        //Obtener los usuarios
        $this->iniciar();

        $registros = $this->ClavesModelo->obtenerClavesPlataforma();

        $datos = [
            'registros' => $registros
        ];

        if(isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1){
            $this->vista('claves/plataforma', $datos);
        } else {
            redireccionar('/login');
            
        }
       
       
    }

    public function general()
    {
       
        //Obtener los usuarios
        $this->iniciar();

        $registros = $this->ClavesModelo->obtenerClavesGeneral();

        $datos = [
            'registros' => $registros
        ];

        if(isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1){
            $this->vista('claves/general', $datos);
        } else {
            redireccionar('/login');
            
        }
       
       
    }

    public function cdev()
    {
       
        //Obtener los usuarios
        $this->iniciar();

        $registros = $this->ClavesModelo->obtenerClavesCdev();

        $datos = [
            'registros' => $registros
        ];

        if(isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1){
            $this->vista('claves/cdev', $datos);
        } else {
            redireccionar('/login');
            
        }
       
       
    }

    public function redessociales()
    {
       
        //Obtener los usuarios
        $this->iniciar();

        $registros = $this->ClavesModelo->obtenerClavesRedesSociales();

        $datos = [
            'registros' => $registros
        ];

        if(isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1){
            $this->vista('claves/redessociales', $datos);
        } else {
            redireccionar('/login');
            
        }
       
       
    }

    public function portalesempleo()
    {
       
        //Obtener los usuarios
        $this->iniciar();

        $registros = $this->ClavesModelo->obtenerClavesPortalesEmpleo();

        $datos = [
            'registros' => $registros
        ];

        if(isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1){
            $this->vista('claves/portalesempleo', $datos);
        } else {
            redireccionar('/login');
            
        }
       
       
    }

    public function usuariospc()
    {
       
        //Obtener los usuarios
        $this->iniciar();

        $registros = $this->ClavesModelo->obtenerClavesUsuariosPc();

        $datos = [
            'registros' => $registros
        ];

        if(isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1){
            $this->vista('claves/usuariospc', $datos);
        } else {
            redireccionar('/login');
            
        }
       
       
    }

    public function agregarPlataforma()
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date("Y-m-d"),
                "pagina_web" => trim($_POST['pagina_web'])

            ];

            if ($this->ClavesModelo->agregarUsuarioPlataforma($datos)) {
                redireccionar('/claves/plataforma');
            } else {
                die('Algo salio mal');
            }
        } else {
            $datos = [
                "nombre" => '',
                "usuario" => '',
                "clave" => '',
                "observaciones" => '',
                "fecha_actualizacion" => '',
                "pagina_web" => ''
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/agregarPlataforma', $datos);
            }
            
        }
    }

    public function agregarGeneral()
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date("Y-m-d"),
                "pagina_web" => trim($_POST['pagina_web'])

            ];

            if ($this->ClavesModelo->agregarUsuarioGeneral($datos)) {
                redireccionar('/claves/general');
            } else {
                die('Algo salio mal');
            }
        } else {
            $datos = [
                "nombre" => '',
                "usuario" => '',
                "clave" => '',
                "observaciones" => '',
                "fecha_actualizacion" => '',
                "pagina_web" => ''
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/agregarGeneral', $datos);
            }
            
        }
    }

    public function agregarCdev()
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date("Y-m-d"),
                "pagina_web" => trim($_POST['pagina_web'])

            ];

            if ($this->ClavesModelo->agregarUsuarioCdev($datos)) {
                redireccionar('/claves/cdev');
            } else {
                die('Algo salio mal');
            }
        } else {
            $datos = [
                "nombre" => '',
                "usuario" => '',
                "clave" => '',
                "observaciones" => '',
                "fecha_actualizacion" => '',
                "pagina_web" => ''
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/agregarCdev', $datos);
            }
            
        }
    }

    public function agregarRedesSociales()
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date("Y-m-d"),
                "pagina_web" => trim($_POST['pagina_web'])

            ];

            if ($this->ClavesModelo->agregarUsuarioRedesSociales($datos)) {
                redireccionar('/claves/redessociales');
            } else {
                die('Algo salio mal');
            }
        } else {
            $datos = [
                "nombre" => '',
                "usuario" => '',
                "clave" => '',
                "observaciones" => '',
                "fecha_actualizacion" => '',
                "pagina_web" => ''
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/agregarRedessociales', $datos);
            }
            
        }
    }

    public function agregarPortalesEmpleo()
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date("Y-m-d"),
                "pagina_web" => trim($_POST['pagina_web'])

            ];

            if ($this->ClavesModelo->agregarUsuarioPortalesEmpleo($datos)) {
                redireccionar('/claves/portalesempleo');
            } else {
                die('Algo salio mal');
            }
        } else {
            $datos = [
                "nombre" => '',
                "usuario" => '',
                "clave" => '',
                "observaciones" => '',
                "fecha_actualizacion" => '',
                "pagina_web" => ''
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/agregarPortalesempleo', $datos);
            }
            
        }
    }

    public function agregarUsuariosPc()
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date("Y-m-d"),
                "pagina_web" => trim($_POST['pagina_web'])

            ];

            if ($this->ClavesModelo->agregarUsuarioUsuariosPc($datos)) {
                redireccionar('/claves/usuariospc');
            } else {
                die('Algo salio mal');
            }
        } else {
            $datos = [
                "nombre" => '',
                "usuario" => '',
                "clave" => '',
                "observaciones" => '',
                "fecha_actualizacion" => '',
                "pagina_web" => ''
            ];
            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/agregarUsuariosPc', $datos);
            }
            
        }
    }


    public function editarPlataforma($id)
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id,
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date('Y-m-d'),
                "pagina_web" => trim($_POST['pagina_web'])
            ];

            if ($this->ClavesModelo->actualizarUsuarioPlataforma($datos)) {
                redireccionar('/claves/plataforma');
            } else {
                die('Algo salio mal');
            }
        } else {

            //obtener informacion del usuario desde el modelo
            $usuario = $this->ClavesModelo->obtenerUsuarioIdPlataforma($id);


            $datos = [
                "idClave" => $usuario->idClave,
                "nombre" => $usuario->nombre,
                "usuario" => $usuario->usuario,
                "clave" => $usuario->clave,
                "observaciones" => $usuario->observaciones,
                "fecha_actualizacion" => $usuario->fecha_actualizacion,
                "pagina_web" => $usuario->pagina_web
            ];
            

            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/editarPlataforma', $datos);
            }
           
        }
    }


    public function editarGeneral($id)
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id,
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date("Y-m-d"),
                "pagina_web" => trim($_POST['pagina_web'])
            ];

            if ($this->ClavesModelo->actualizarUsuarioGeneral($datos)) {
                redireccionar('/claves/general');
            } else {
                die('Algo salio mal');
            }
        } else {

            //obtener informacion del usuario desde el modelo
            $usuario = $this->ClavesModelo->obtenerUsuarioIdGeneral($id);


            $datos = [
                "idClave" => $usuario->idClave,
                "nombre" => $usuario->nombre,
                "usuario" => $usuario->usuario,
                "clave" => $usuario->clave,
                "observaciones" => $usuario->observaciones,
                "fecha_actualizacion" => $usuario->fecha_actualizacion,
                "pagina_web" => $usuario->pagina_web
            ];
            

            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/editarGeneral', $datos);
            }
           
        }
    }

    public function editarCdev($id)
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id,
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date("Y-m-d"),
                "pagina_web" => trim($_POST['pagina_web'])
            ];

            if ($this->ClavesModelo->actualizarUsuarioCdev($datos)) {
                redireccionar('/claves/cdev');
            } else {
                die('Algo salio mal');
            }
        } else {

            //obtener informacion del usuario desde el modelo
            $usuario = $this->ClavesModelo->obtenerUsuarioIdCdev($id);


            $datos = [
                "idClave" => $usuario->idClave,
                "nombre" => $usuario->nombre,
                "usuario" => $usuario->usuario,
                "clave" => $usuario->clave,
                "observaciones" => $usuario->observaciones,
                "fecha_actualizacion" => $usuario->fecha_actualizacion,
                "pagina_web" => $usuario->pagina_web
            ];
            

            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/editarCdev', $datos);
            }
           
        }
    }

    public function editarRedesSociales($id)
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id,
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date("Y-m-d"),
                "pagina_web" => trim($_POST['pagina_web'])
            ];

            if ($this->ClavesModelo->actualizarUsuarioRedesSociales($datos)) {
                redireccionar('/claves/redessociales');
            } else {
                die('Algo salio mal');
            }
        } else {

            //obtener informacion del usuario desde el modelo
            $usuario = $this->ClavesModelo->obtenerUsuarioIdRedesSociales($id);


            $datos = [
                "idClave" => $usuario->idClave,
                "nombre" => $usuario->nombre,
                "usuario" => $usuario->usuario,
                "clave" => $usuario->clave,
                "observaciones" => $usuario->observaciones,
                "fecha_actualizacion" => $usuario->fecha_actualizacion,
                "pagina_web" => $usuario->pagina_web
            ];
            

            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/editarRedessociales', $datos);
            }
           
        }
    }

    public function editarPortalesEmpleo($id)
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id,
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date("Y-m-d"),
                "pagina_web" => trim($_POST['pagina_web'])
            ];

            if ($this->ClavesModelo->actualizarUsuarioPortalesEmpleo($datos)) {
                redireccionar('/claves/portalesempleo');
            } else {
                die('Algo salio mal');
            }
        } else {

            //obtener informacion del usuario desde el modelo
            $usuario = $this->ClavesModelo->obtenerUsuarioIdPortalesEmpleo($id);


            $datos = [
                "idClave" => $usuario->idClave,
                "nombre" => $usuario->nombre,
                "usuario" => $usuario->usuario,
                "clave" => $usuario->clave,
                "observaciones" => $usuario->observaciones,
                "fecha_actualizacion" => $usuario->fecha_actualizacion,
                "pagina_web" => $usuario->pagina_web
            ];
            

            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/editarPortalesempleo', $datos);
            }
           
        }
    }

    public function editarUsuariosPc($id)
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id,
                "nombre" => trim($_POST['nombre']),
                "usuario" => trim($_POST['usuario']),
                "clave" => trim($_POST['clave']),
                "observaciones" => trim($_POST['observaciones']),
                "fecha_actualizacion" => date("Y-m-d"),
                "pagina_web" => trim($_POST['pagina_web'])
            ];

            if ($this->ClavesModelo->actualizarUsuarioUsuariosPc($datos)) {
                redireccionar('/claves/usuariospc');
            } else {
                die('Algo salio mal');
            }
        } else {

            //obtener informacion del usuario desde el modelo
            $usuario = $this->ClavesModelo->obtenerUsuarioIdUsuariosPc($id);


            $datos = [
                "idClave" => $usuario->idClave,
                "nombre" => $usuario->nombre,
                "usuario" => $usuario->usuario,
                "clave" => $usuario->clave,
                "observaciones" => $usuario->observaciones,
                "fecha_actualizacion" => $usuario->fecha_actualizacion,
                "pagina_web" => $usuario->pagina_web
            ];
            

            if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
                redireccionar('/login');
            } else {
              
                $this->vista('claves/editarUsuariosPc', $datos);
            }
           
        }
    }

    public function borrarPlataforma($id)
    {
        $this->iniciar();
        //obtener informacion del usuario desde el modelo
        $usuario = $this->ClavesModelo->obtenerUsuarioIdPlataforma($id);


        $datos = [
            "idClave" => $usuario->idClave,
            "nombre" => $usuario->nombre,
            "usuario" => $usuario->usuario,
            "clave" => $usuario->clave,
            "observaciones" => $usuario->observaciones,
            "fecha_actualizacion" => $usuario->fecha_actualizacion,
            "pagina_web" => $usuario->pagina_web
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id
            ];

            if ($this->ClavesModelo->borrarUsuarioPlataforma($datos)) {
                redireccionar('/claves/plataforma');
            } else {
                die('Algo salio mal');
            }
        }
    
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
          
            $this->vista('claves/borrarPlataforma', $datos);
        }
     
    }

    public function borrarGeneral($id)
    {
        $this->iniciar();
        //obtener informacion del usuario desde el modelo
        $usuario = $this->ClavesModelo->obtenerUsuarioIdGeneral($id);


        $datos = [
            "idClave" => $usuario->idClave,
            "nombre" => $usuario->nombre,
            "usuario" => $usuario->usuario,
            "clave" => $usuario->clave,
            "observaciones" => $usuario->observaciones,
            "fecha_actualizacion" => $usuario->fecha_actualizacion,
            "pagina_web" => $usuario->pagina_web
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id
            ];

            if ($this->ClavesModelo->borrarUsuarioGeneral($datos)) {
                redireccionar('/claves/general');
            } else {
                die('Algo salio mal');
            }
        }
    
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
          
            $this->vista('claves/borrarGeneral', $datos);
        }
     
    }

    public function borrarCdev($id)
    {
        $this->iniciar();
        //obtener informacion del usuario desde el modelo
        $usuario = $this->ClavesModelo->obtenerUsuarioIdCdev($id);


        $datos = [
            "idClave" => $usuario->idClave,
            "nombre" => $usuario->nombre,
            "usuario" => $usuario->usuario,
            "clave" => $usuario->clave,
            "observaciones" => $usuario->observaciones,
            "fecha_actualizacion" => $usuario->fecha_actualizacion,
            "pagina_web" => $usuario->pagina_web
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id
            ];

            if ($this->ClavesModelo->borrarUsuarioCdev($datos)) {
                redireccionar('/claves/cdev');
            } else {
                die('Algo salio mal');
            }
        }
    
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
          
            $this->vista('claves/borrarCdev', $datos);
        }
     
    }


    public function borrarRedesSociales($id)
    {
        $this->iniciar();
        //obtener informacion del usuario desde el modelo
        $usuario = $this->ClavesModelo->obtenerUsuarioIdRedesSociales($id);


        $datos = [
            "idClave" => $usuario->idClave,
            "nombre" => $usuario->nombre,
            "usuario" => $usuario->usuario,
            "clave" => $usuario->clave,
            "observaciones" => $usuario->observaciones,
            "fecha_actualizacion" => $usuario->fecha_actualizacion,
            "pagina_web" => $usuario->pagina_web
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id
            ];

            if ($this->ClavesModelo->borrarUsuarioRedesSociales($datos)) {
                redireccionar('/claves/redessociales');
            } else {
                die('Algo salio mal');
            }
        }
    
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
          
            $this->vista('claves/borrarRedessociales', $datos);
        }
     
    }


    public function borrarPortalesEmpleo($id)
    {
        $this->iniciar();
        //obtener informacion del usuario desde el modelo
        $usuario = $this->ClavesModelo->obtenerUsuarioIdPortalesEmpleo($id);


        $datos = [
            "idClave" => $usuario->idClave,
            "nombre" => $usuario->nombre,
            "usuario" => $usuario->usuario,
            "clave" => $usuario->clave,
            "observaciones" => $usuario->observaciones,
            "fecha_actualizacion" => $usuario->fecha_actualizacion,
            "pagina_web" => $usuario->pagina_web
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id
            ];

            if ($this->ClavesModelo->borrarUsuarioPortalesEmpleo($datos)) {
                redireccionar('/claves/portalesempleo');
            } else {
                die('Algo salio mal');
            }
        }
    
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
          
            $this->vista('claves/borrarPortalesempleo', $datos);
        }
     
    }


    public function borrarUsuariosPc($id)
    {
        $this->iniciar();
        //obtener informacion del usuario desde el modelo
        $usuario = $this->ClavesModelo->obtenerUsuarioIdUsuariosPc($id);


        $datos = [
            "idClave" => $usuario->idClave,
            "nombre" => $usuario->nombre,
            "usuario" => $usuario->usuario,
            "clave" => $usuario->clave,
            "observaciones" => $usuario->observaciones,
            "fecha_actualizacion" => $usuario->fecha_actualizacion,
            "pagina_web" => $usuario->pagina_web
        ];

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idClave" => $id
            ];

            if ($this->ClavesModelo->borrarUsuarioUsuariosPc($datos)) {
                redireccionar('/claves/usuariospc');
            } else {
                die('Algo salio mal');
            }
        }
    
        if(!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1){
            redireccionar('/login');
        } else {
          
            $this->vista('claves/borrarUsuariosPc', $datos);
        }
     
    }

}