<?php


class Proveedores extends Controlador
{

    public function __construct()
    {
        // cargamos el modelo asociado a este controlador
        $this->proveedorModelo = $this->modelo('ModeloProveedores');
    } // fin del constructor

    public function index()
    {

        //Obtener los usuarios
        $this->iniciar();

        $proveedores = $this->proveedorModelo->obtenerProveedores();

        $datos = [
            'proveedores' => $proveedores
        ];

        if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
            $this->vista('Proveedores/proveedores', $datos);
        } else {
            redireccionar('/login');
        }
    } // fin de la fucnion index


    public function materiales()
    {

        //Obtener los usuarios
        $this->iniciar();

        $materiales = $this->proveedorModelo->listadoMateriales();

        $datos = [
            'materiales' => $materiales
        ];

        if (isset($_SESSION['autorizado']) || $_SESSION['autorizado'] == 1) {
            $this->vista('Proveedores/materiales', $datos);
        } else {
            redireccionar('/login');
        }
    } // fin de la fucnion index

    public function obtenerDatosSelects()
    {

        $datosProveedores = $this->proveedorModelo->obtenerDatosProveedores();
        $datosPlazos = $this->proveedorModelo->obtenerPlazosPago(); //TODO PONER PLAZOS DE PAGO

        $resultado = [
            "proveedores" => $datosProveedores,
            "plazos" => $datosPlazos
        ];

        echo json_encode($resultado);
    }

    public function addProveedor()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $datosNuevo = [];
            foreach ($_POST['form'] as $row) {
                $datosNuevo[$row['name']] = $row['value'];
            }

            $campos = ['NOMBRECOMERCIAL','CIFPROVEEDOR','PERSONAJURIDICA','PERSONACONTACTO1','PERSONACONTACTO2','DIRECCION','POBLACION','PROVINCIA','CODPOSTAL','TELEFONOFIJO',
            'TELEFONOMOVIL','FAX','EMAIL','WEB','NUMCUENTA','TIPODEPROVEEDOR','CODFORMAPAGO','enlace','OBSERVACIONES'];

            $values = ["'".$datosNuevo['nombreComercial']."'","'".$datosNuevo['cif']."'","'".$datosNuevo['razonSocial']."'","'".$datosNuevo['personaContacto1']."'","'".$datosNuevo['personaContacto2']."'","'".$datosNuevo['direccion']."'","'".$datosNuevo['poblacion']."'",
            "'".$datosNuevo['provincia']."'","'".$datosNuevo['codPostal']."'","'".$datosNuevo['telefonofijo1']."'","'".$datosNuevo['movil']."'","'".$datosNuevo['fax']."'","'".$datosNuevo['email']."'","'".$datosNuevo['web']."'","'".$datosNuevo['ncc']."'",
            "'".$datosNuevo['tipoProveedor']."'","'".$datosNuevo['plazosPago']."'","'".$datosNuevo['ctacte']."'","'".$datosNuevo['observaciones']."'"];

            $datos = [
                "campos" => implode(',', $campos),
                "values" => implode(',', $values)
            ];

            $resultado = $this->proveedorModelo->insertProveedor($datos);

            echo json_encode($resultado);

        }
    }

    public function cargarDatosProveedorById()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // print_r($_POST['idProveedor']);
            // die;

            $datosProveedores = $this->proveedorModelo->obtenerDatosProveedores();
            $datosPlazos = $this->proveedorModelo->obtenerPlazosPago(); 
            $datosProveedor = $this->proveedorModelo->obtenerDatosProveedorById($_POST['idProveedor']);

            $resultado = [
                "proveedores" => $datosProveedores,
                "plazos" => $datosPlazos,
                "proveedor" => $datosProveedor
            ];

            echo json_encode($resultado);

        }


    }

    public function editarProveedor()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datosPost = $_POST;
        }

        $datos = [
            "idProveedor" => $datosPost['idProveedor'],
            "tabla" => $datosPost['tabla'],
            "campo" => $datosPost['campo'],
            "valor" => $datosPost['valor'],
            "pk" => $datosPost['pk']
        ];

        $this->proveedorModelo->actualizarDatosProveedor($datos);
    }

    public function deleteProveedor()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idProveedor = $_POST['idProveedor'];
        }

        $resultado = $this->proveedorModelo->deleteProveedor($idProveedor);

        echo json_encode($resultado);
    }
}
