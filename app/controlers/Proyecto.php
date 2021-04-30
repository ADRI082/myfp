<?php
//require_once dirname(__FILE__).'/../../vendor/autoload.php';
require '../public/vendor/autoload.php';
require('fpdf182/fpdf.php');

use PhpOffice\PhpSpreadsheet\IOFactory;

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

use function GuzzleHttp\json_decode;

class Proyecto extends Controlador
{


    public function __construct()
    {
        $this->ModelProyecto = $this->modelo('ModeloProyecto');
        $this->ModeloConfiguracion = $this->modelo('ModeloConfiguracion');
    }

    public function index()
    {
        $this->iniciar();

        $clientes = $this->ModelProyecto->obtenerClientes();
        $profesores = $this->ModelProyecto->obtenerProfesores();
        $colaboradores = $this->ModelProyecto->obtenerColaboradores();
        $acciones = $this->ModelProyecto->obtenerAcciones();
        $tipos = $this->ModelProyecto->obtenerTipos();
        $areas = $this->ModelProyecto->obtenerAreas();
        $modalidades = $this->ModelProyecto->obtenerModalidades();

        $datos = [
            'clientes' => $clientes,
            'profesores' => $profesores,
            'colaboradores' => $colaboradores,
            'acciones' => $acciones,
            'tipos' => $tipos,
            'areas' => $areas,
            'modalidades' => $modalidades
        ];

        if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
            redireccionar('/login');
        } else {

            $this->vista('/proyecto/proyecto', $datos);
        }
    }

    public function listaProyectos($msg = 0)
    {
        $this->iniciar();

        //$listado = $this->ModelProyecto->listaProyectos();
        $listado = $this->ModelProyecto->listaProyectosPorAccionPresupuestoFecha();

        $datos = [
            'listado' => $listado,
            'msg' => $msg
        ];

        if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
            redireccionar('/login');
        } else {

            $this->vista('proyecto/listaProyectos', $datos);
        }
    }

    public function fichaProyecto($id, $msg = 0)
    {

        $this->iniciar();

        /*$partes = explode("_",$id);
            $idPresupuesto = $partes[0];
            $idAccionPres = $partes[1];
            $fechaInicio = $partes[2];*/

        /*$data = [
                "id" => $idPresupuesto,
                "idAccionPres" => $idAccionPres,
                "fechaInicio" => $fechaInicio
            ];*/

        //$ficha = $this->ModelProyecto->fichaProyecto($data);            
        $ficha = $this->ModelProyecto->fichaProyecto($id);
        $niveles = $this->ModelProyecto->nivelesDeCursos();
        $modalidades = $this->ModelProyecto->obtenerModalidades();
        $acciones = $this->ModelProyecto->obtenerAcciones();
        $datos = [
            "generales" => $ficha['generales'],
            "detalles" => $ficha['detalles'],
            "clientes" => $ficha['clientes'],
            "profesores" => $ficha['profesores'],
            "profesoresProy" => $ficha['profesoresProy'],
            "participantes" => $ficha['participantes'],
            "empleados" => $ficha['empleados'],
            "niveles" => $niveles,
            "modalidades" => $modalidades,
            "acciones" => $acciones,
            'msg' => $msg
        ];

        if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
            redireccionar('/login');
        } else {
            $this->vista('proyecto/fichaProyecto', $datos);
        }
    }

    public function buscarAccionesProyectoPorClientes()
    {

        $this->iniciar();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $salida = [
                "idCliente" => $_POST['idCliente'],
                "idPresupuesto" => $_POST['idPresupuesto'],
                "idProyecto" => $_POST['idProyecto'],
                "idAccion" => $_POST['idAccion'],
                // "idAccionProy" => $_POST['idAccionProy'],
                "fechaInicio" => $_POST['fechaInicio'],
            ];

            $registros = $this->ModelProyecto->buscarAccionesProyectoPorClientes($salida);
            $tipoCostes = $this->ModelProyecto->obtenerTipoCostes();
            $costesProy = $this->ModelProyecto->obtenerCostesAccionProyecto($salida);
            $tipoGastos = $this->ModelProyecto->obtenerTipoGastos();
            $gastosProy = $this->ModelProyecto->obtenerGastosAccionProyecto($salida);
            $ctasBancarias = $this->ModelProyecto->obtenerCuentasBancarias();
            $selectEmails = $this->ModelProyecto->obtenerEmailsCliente($salida);
            $participantesCliente = $this->ModelProyecto->obtenerParticipantesPorCliente($salida);

            $datos = [
                "registros" => $registros,
                "tipoCostes" => $tipoCostes,
                "costesProy" => $costesProy,
                // "facturasProy" => $facturasProy,
                "tipoGastos" => $tipoGastos,
                "gastosProy" => $gastosProy,
                'ctasBancarias' => $ctasBancarias,
                'selectEmails' => $selectEmails,
                'participantesCliente' => $participantesCliente
            ];

            $tipoConcepto = [
                'Formación - Organizador' => 1,
                'Formación - Autogestión' => 2,
                'Gestión Formación' => 3,
                'Gestión Consultoría' => 4,
                'Gestión Selección' => 5
            ];

            $folios = [
                "Folio1", "Folio2", "Folio3"
            ];

            $ctasBancarias = $this->ModelProyecto->obtenerCuentasBancarias();
            $facturasProy = $this->ModelProyecto->obtenerFacturasAccionProyecto($salida);

            $html = '<input type="hidden" value="' . $registros->idAccionProy . '" name="idAccionProy" id="idAccionProy">
                    <input type="hidden" value="' . $registros->idAccionPres . '" name="idAccionPres" id="idAccionPres">
                   
                    <p style="color: blue;">Ingresos del proyecto</p>
                    <div id="lineasFacturas">
                        <div class="d-flex justify-content-start">
                            <input type="hidden" id="contadorLineas" value="0">
                            <a  id="addLineaIngreso" title="Agregar factura de ingreso"><i class="fas fa-plus-square"></i></a>                            
                        </div>';



            $cont = 0;
            foreach ($facturasProy as $key) {
                $cont++;
                $clase = '';
                $checked = '';
                if ($cont % 2 != 0) {
                    $clase = 'lineasPares';
                } else {
                    $clase = 'lineasImpares';
                }
                if ($key->predefinido == 1) {
                    $checked = 'checked';
                }
                $html2 = '<div class="row mb-3 lineaFact ' . $clase . ' lineas" id="lineaFactura_' . $key->idfactura . '">'
                    .    '<div class="form-group row col-md-12 mb-0">'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Cantidad</label>'
                    .           '<input id="cantidad' . $key->idfactura . '" value="' . $key->cantidad . '" data-fila="' . $key->idfactura . '" '
                    .               'type="number" data-pk="idfactura" data-idfactura="' . $key->idfactura . '" data-tabla="facturascabecera" step="0.001" class="text-right form-control lineaCoste cantidad inputRecalculo campotabla '
                    .               'px-0" name="cantidad" required >'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Importe</label>'
                    .           '<input id="importeFactura' . $key->idfactura . '" data-idfactura="' . $key->idfactura . '" data-pk="idfactura" data-tabla="facturascabecera" value="' . $key->importe . '" data-fila="' . $key->idfactura . '" type="number" step="0.001" class="text-right form-control lineaCoste importeFactura inputRecalculo campotabla px-0" name="importe" required>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">IVA(%)</label>'
                    .           '<input id="iva' . $key->idfactura . '" value="' . $key->iva . '" data-idfactura="' . $key->idfactura . '"  data-pk="idfactura" data-tabla="facturascabecera" data-fila="' . $key->idfactura . '" type="number" step="0.001" class="text-right form-control lineaCoste iva inputRecalculo campotabla px-0" name="iva" required>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Total</label>'
                    .           '<input id="total' . $key->idfactura . '" value="' . $key->total . '" data-idfactura="' . $key->idfactura . '" data-pk="idfactura" data-tabla="facturascabecera" type="number" step="0.001" class="text-right form-control lineaCoste total  px-0" name="total" required readonly>'
                    .       '</div>'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Fecha</label>'
                    .           '<input id="fechaFactura' . $key->idfactura . '" value="' . $key->fechafactura . '" data-idfactura="' . $key->idfactura . '" data-pk="idfactura" data-tabla="facturascabecera" type="date" class="form-control lineaCoste campotabla" name="fechafactura" required>'
                    .       '</div>';
                $html2 .=           '<div class="col-md-3 col-sm-2">'
                    .           '<label class="labelCampoPres">IBAN</label>'
                    .           '<select id="iban' . $key->idfactura . '" type="text" data-pk="idfactura" data-idfactura="' . $key->idfactura . '" data-tabla="facturascabecera" class="form-control lineaCoste todos campotabla" name="iban">'
                    .               '<option disabled selected>Seleccionar</option>';
                foreach ($ctasBancarias as $cuenta) {
                    $html2 .=           '<option  value="' . $cuenta->idcuenta . '" ' . (($cuenta->idcuenta == $key->iban) ? 'selected' : '') . '>' . $cuenta->iban . '</option>';
                }
                $html2 .=               '</select>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Nº Factura</label>'
                    .           '<input id="numFactura' . $key->idfactura . '" data-idfactura="' . $key->idfactura . '" data-pk="idfactura" data-tabla="facturascabecera" value="' . $key->numfactura . '" type="text" class="form-control lineaCoste px-0 text-center campotabla" name="numfactura" style="width: 100%; padding-left:0.15rem;padding-right:0.15rem;" readonly>'
                    .       '</div>'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Fecha Cobro</label>'
                    .           '<input id="fechaCobro' . $key->idfactura . '"value="' . $key->fechacobro . '" data-idfactura="' . $key->idfactura . '" data-pk="idfactura" data-tabla="facturascabecera" type="date" class="form-control lineaCoste campotabla" name="fechacobro">'
                    .       '</div>'
                    .       '<div class="col-md-3 col-sm-2">'
                    .           '<label class="labelCampoPres">Tipo concepto</label>'
                    .           '<select id="tipoConcepto' . $key->idfactura . '"  type="text" class="form-control lineaCoste tipoConcepto todos" data-concepto="1" data-indice="' . $key->idfactura . '" data-idfactura="' . $key->idfactura . '" data-pk="idfactura" data-tabla="facturascabecera" name="tipoconcepto">'
                    .               '<option disabled selected>Seleccionar</option>';
                foreach ($tipoConcepto as $clave => $value) {
                    $html2 .=           '<option  value="' . $value . '" ' . (($value == $key->tipoconcepto) ? 'selected' : '') . '>' . $clave . '</option>';
                }
                $html2  .=          '</select>'
                    .       '</div>'
                    .       '<div class="col-md-3 col-sm-2">'
                    .           '<label class="labelCampoPres">Concepto</label>'
                    .           '<div>'
                    .               '<a class="btn btn-secondary text-white editarConcepto" id="editarConcepto' . $key->idfactura . '" data-idfactura="' . $key->idfactura . '" data-indice="' . $key->idfactura . '">Editar concepto <i class="fas fa-chevron-down" style="color:white;"></i></a>'
                    .           '</div>'
                    .       '</div>'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Tipo Folio</label>'
                    .             '<select id="tipoFolio' . $key->idfactura . '" data-nueva=0  data-idfactura="' . $key->idfactura . '" data-pk="idfactura" data-tabla="facturascabecera"  data-fila="' . $key->idfactura . '" type="text" class="form-control lineaGasto selectEdit campotabla tipoFolio" name="tipofolio">'
                    . '<option>Seleccionar</option>';
                foreach ($folios as $folio) {
                    $html2 .= '<option value="' . strtolower($folio) . '" ' . ((strtolower($folio) == $key->tipofolio) ? 'selected' : '') . '>' . $folio . '</option>';
                }
                $html2 .=  '</select>'
                    .       '</div>'
                    .       '<div class="col-md-2 col-sm-2" style="display:none;">'
                    .           '<label class="labelCampoPres">Predefinido</label>'
                    .           '<div class="d-lg-flex mb-1">'
                    .               '<input class="form-check-input conceptoPredefinido campotabla" data-idfactura="' . $key->idfactura . '" data-pk="idfactura" data-tabla="facturascabecera" type="checkbox" data-idaccion="' . $key->idfactura . '"'
                    .                   'id="checkPredefinido' . $key->idfactura . '" name="predefinido" value="0" ' . $checked . '>'
                    .           '</div>'
                    .       '</div>'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Acciones</label>'
                    .           '<div class="d-lg-flex mb-1">'
                    .               '<input class="form-check-input marcaraccion campotabla" data-idfactura="' . $key->idfactura . '" data-pk="idfactura" data-tabla="facturascabecera" type="checkbox" data-idaccion="' . $key->idfactura . '"'
                    .                   'id="checkAccion' . $key->idfactura . '" name="checkAccionNuevo[]" value="' . $key->idfactura . '">'
                    .                '<a id="btnEnviarFila' . $key->idfactura . '" data-indice="' . $key->idfactura . '" data-folio="' . $key->tipofolio . '" class="btn btn-primary mr-1 enviarFactura" name="btnFacturarFila" title="Enviar Email" style="float:right"><i class="fas fa-envelope-square" style="color:white;float:right;"></i></a>'
                    .                '<a id="btnPDFFila' . $key->idfactura . '" data-indice="' . $key->idfactura . '" class="btn btn-secondary mr-1 btnPDFFacturar" title="PDF" style="float:right" target="_blank"><i class="fas fa-file-pdf" style="color:white;float:right;"></i></a>'
                    .                '<a id="btnFacturaNegativa' . $key->idfactura . '" data-indice="' . $key->idfactura . '" ' . (($key->total < 0) ? 'class="d-none d-print-block"' : 'class="btn btn-danger mr-1 facturaNegativa "') . '  name="" title="" style="float:right" target="_blank"><i class="fas fa-minus-square" style="color:white;float:right;"></i></a>'
                    .           '</div>'
                    .       '</div>'
                    .        '<div class="col-md-12 col-sm-12 mt-2 mb-4" id="contEditorConcepto' . $key->idfactura . '"  style="display:none;">'
                    .           '<textarea data-idfactura="' . $key->idfactura . '" data-pk="idfactura" data-tabla="facturascabecera" id="editor' . $key->idfactura . '"  name="concepto" rows="1" cols="10" class="form-control campotabla">' . $key->concepto . '</textarea><br>'
                    .        '</div>'
                    .     '<input type="hidden" id="tipoFolioSeleccionado' . $key->idfactura . '" value="' . $key->tipofolio . '">'
                    .   '</div>';
                $html2 .= '</div>';
                $html .= $html2;
            }

            $html .= '</div>';

            $html .= '<p style="color: blue;" class="mt-5">Gastos del Proyecto</p>'
                .     '<div class="LineaGastos" id="contenedorLineasGastos">'
                .       '<div class="d-flex justify-content-start">'
                .           '<input type="hidden" id="lineasGastos" value="0">'
                .           '<a id="addLineaGasto" title="Agregar factura de Gasto"><i class="fas fa-plus-square"></i></a>'
                .       '</div>'
                .     '</div>';

            $html .= '<p style="color: blue;" class="mt-5">Gastos del Proyecto Comunes</p>'
                .       '<div class = "mb-3">'
                .        '<label style="color: #001f3f;">Agregar Gasto Común</label>'
                .        '<a  id="addLineaGastoComun" class="ml-2 mt-2" title="Agregar Gasto Común"><i class="fas fa-plus-square"></i></a>'
                .        '</div>'
                .     '<div class="LineaGastosComunes" id="contenedorLineasGastosComunes">'
                .       '<div class="d-flex justify-content-start">'
                .       '</div>'
                .     '</div>'
                .     '<input type="hidden" id="checkGastosComunes" value="0">';


            $lineasGastos = $this->pintarGastosProyecto($gastosProy, $salida);
            $lineasGastosComunes =  $this->pintarGastosComunesProyecto($gastosProy, $salida);
            $emails = $this->pintarTablaEmailsCliente($salida);

            $respuesta = [
                "html" => $html,
                "htmlGastos" => $lineasGastos,
                "htmlGastosComunes" => $lineasGastosComunes,
                "htmlEmails" => $emails,
                "gastosProyecto" => $gastosProy
            ];

            echo json_encode($respuesta);
        }
    }

    public function pintarTablaEmailsCliente($salida)
    {

        $emails = $this->ModelProyecto->obtenerEmailsByIdCliente($salida);


        $salida = '';

        $salida .= '<table class="table">'
            . '<thead>'
            . ' <tr>'
            . ' <th scope="col" class="text-center">Cliente</th>'
            . '<th scope="col" class="text-center">Asunto</th>'
            . ' <th scope="col" class="text-center">Nombre Usuario</th>'
            . ' <th scope="col" class="text-center">Fecha</th>'
            . ' <th scope="col" class="text-center">Detalle</th>'
            . ' </tr>'
            . ' </thead>'
            . '<tbody> ';
        foreach ($emails as $key) {
            $salida .=  '<tr>'
                . '<td class="text-center">' . $key->NOMBREJURIDICO . '</td>'
                . '<td class="text-center">' . $key->subject . '</td>'
                . '<td class="text-center">' . $key->Nombre . '</td>'
                . '<td class="text-center">' . date("d-m-Y", strtotime($key->fecha)) . '</td>'
                . '<td class="text-center"><a href="#Detalle"  class="detalleEmail btn btn-xs btn-primary" data-id="' . $key->idEmail . '" type="button" data-toggle="modal" title="Detalle"><i class="far fa-eye"></i></a></td>'
                . '</tr>';
        };
        $salida .= '</tbody>'
            . '</table> ';



        return $salida;
    }

    public function pintarGastosProyecto($gastosProyecto, $salida)
    {






        $tipoGastos = $this->ModelProyecto->obtenerTipoGastosGenerales($salida);
        $ctasBancarias = $this->ModelProyecto->obtenerCuentasBancarias();


        $proveedores = [
            "Proveedor", "Profesor", "Colaborador"
        ];

        $html = '';
        $cont = 0;

        foreach ($gastosProyecto as $key) {

            if ($key->gastocomun != 1) {

                $cont++;
                $clase = '';
                $checked = '';
                if ($cont % 2 != 0) {
                    $clase = 'lineasPares';
                } else {
                    $clase = 'lineasImpares';
                }

                if ($key->tipoProveedor == 'proveedor') { //
                    $razon = $this->getProveedoresSelect(true, $key->razonSocial);
                } else if ($key->tipoProveedor == 'profesor') { //
                    $razon = $this->getProfesoresSelect(true, $key->razonSocial);
                } else if ($key->tipoProveedor == 'colaborador') { //
                    $razon = $this->getColaboradoresSelect(true, $key->razonSocial);
                }

                $salida = '<div class="row ' . $clase . ' mb-3 lineasGasto" id="lineaGasto_' . $key->idgasto . '">'
                    .    '<div class="form-group row col-md-12 mb-0">'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Tipo gasto</label>'
                    . '<select id="gasto' . $key->idgasto . '" type="text" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" class="form-control lineaGasto selectEdit todos" name="tipoGasto">'
                    . '<option>Seleccionar</option>';
                foreach ($tipoGastos as $gastos) {
                    $salida .= '<option value="' . $gastos->idgasto . '" ' . (($gastos->idgasto == $key->tipoGasto) ? 'selected' : '') . '>' . $gastos->descripcion . '</option>';
                }
                $salida .=  '</select>'
                    .       '</div>'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Tipo Proveedor</label>'
                    .             '<select id="proveedor' . $key->idgasto . '" data-nueva=0  data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="text" class="form-control lineaGasto selectEdit campotabla tipoProveedor" name="tipoProveedor">'
                    . '<option>Seleccionar</option>';
                foreach ($proveedores as $proveedor) {
                    $salida .= '<option value="' . strtolower($proveedor) . '" ' . ((strtolower($proveedor) == $key->tipoProveedor) ? 'selected' : '') . '>' . $proveedor . '</option>';
                }
                $salida .=  '</select>'
                    .       '</div>'
                    .       ' <div class="col-md-3 col-sm-2">'
                    .           '<label class="labelCampoPres">Razón Social</label>'
                    .       '<select id="razonSocial' . $key->idgasto . '" type="text" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '"   class="form-control selectEdit lineaGasto  todos" name="razonSocial">'
                    .       $razon
                    .       '</select>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Importe</label>'
                    .           '<input id="importeGasto' . $key->idgasto . '" value="' . $key->importe . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '"   type="number" data-fila="' . $key->idgasto . '" class="text-right  form-control campotabla lineaGasto importeGasto total" name="importe" required>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Cantidad</label>'
                    .           '<input id="cantidadGasto' . $key->idgasto . '" value="' . $key->cantidad . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '"  type="number" data-fila="' . $key->idgasto . '" class="form-control campotabla cantidadGasto lineaGasto" name="cantidad" required>'
                    .       '</div>'
                    .     ' <div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">IVA</label>'
                    .           '<input id="ivaGasto' . $key->idgasto . '" value="' . $key->iva . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '"  type="number" data-fila="' . $key->idgasto . '" class="form-control campotabla ivaGasto lineaGasto"  name="iva" style="width: 100%;" >'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">IRPF</label>'
                    .               ' <input id="irpf' . $key->idgasto . '" value="' . $key->irpf . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="number" data-fila="' . $key->idgasto . '" class="form-control campotabla irpf  lineaGasto" name="irpf" style="width: 100%;" >'
                    .               '</div>'
                    . ' <div class="col-md-1 col-sm-2">'
                    . '<label class="labelCampoPres">Total</label>'
                    . '<input id="totalGasto' . $key->idgasto . '" value="' . $key->total . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" data-fila="' . $key->idgasto . '" type="number" class="form-control cambiarTotal lineaGasto" name="total" readonly>'
                    . ' </div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . ' <label class="labelCampoPres">Num. Factura</label>'
                    . '<input id="numFactura' . $key->idgasto . '" value="' . $key->numfacgasto . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="text" class="form-control campotabla lineaGasto" name="numfacgasto" style="width: 100%;">'
                    . '</div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . '<label class="labelCampoPres">Fecha Factura</label>'
                    . '<input id="fechaFactura' . $key->idgasto . '" value="' . $key->fecha . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="date" class="form-control campotabla lineaGasto" name="fecha">'
                    . '</div>';
                $salida .=      '<div class="col-md-3 col-sm-2">'
                    .           '<label class="labelCampoPres">IBAN</label>'
                    .           '<select id="ibanGasto' . $key->idgasto . '" data-nueva=0  data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="text" class="form-control lineaGasto selectEdit todos" name="iban">'
                    .               '<option disabled selected>Seleccionar</option>';
                foreach ($ctasBancarias as $cuenta) {
                    $salida .= '<option value="' . $cuenta->idcuenta . '" ' . (($cuenta->idcuenta == $key->iban) ? 'selected' : '') . '>' . $cuenta->iban . '</option>';
                }
                $salida .=  '</select>'
                    .  '</div>'
                    . '<div class="col-md-3 col-sm-2">'
                    . '<label class="labelCampoPres">Concepto</label>'
                    . '<textarea id="editor' . $key->idgasto . '"  data-idfactura="' . $key->idgasto . '" data-pk="idfactura" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" name="descripcion" rows="1" cols="10" class="form-control campotabla">"' . strip_tags($key->descripcion) . '"</textarea><br>'
                    . '</div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . '<label class="labelCampoPres">Fecha Pago</label>'
                    . '<input id="fechaCobro' . $key->idgasto . '" value="' . $key->fechapago . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="date" class="form-control lineaGasto campotabla" name="fechapago">'
                    . '</div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . '<label class="labelCampoPres">Acciones</label>'
                    . '<div class="d-lg-flex mb-1">'
                    . '<input class="form-check-input marcaraccion" type="checkbox"  id="checkAccionGastos' . $key->idgasto . '" name="checkAccionGastoNuevo[]" value="' . $key->idgasto . '">'
                    . '<a id="btnEliminarFilaGastos' . $key->idgasto . '" class="btn btn-danger mr-1 btnEliminarGasto" data-idgasto="' . $key->idgasto . '" data-gastos="1" name="btnFacturarFila" title="Eliminar" style="float:right"><i class="fas fa-trash-alt" style="color:white;float:right;"></i></a>'
                    . '</div>'
                    . '</div>'
                    . '</div>'
                    . '</div>';
                $html .= $salida;
            }
        }


        return $html;
    }

    public function pintarGastosComunesProyecto($gastosProyecto, $salida)
    {


        $tipoGastos = $this->ModelProyecto->obtenerTipoGastosGenerales($salida);
        $ctasBancarias = $this->ModelProyecto->obtenerCuentasBancarias();


        $proveedores = [
            "Proveedor", "Profesor", "Colaborador"
        ];

        $html = '';
        $cont = 0;
        $clase = '';

        foreach ($gastosProyecto as $key) {

            $lineasGastosClientes = $this->ModelProyecto->obtenerGastosClientesComun($key->idgasto);

            $cont++;
            if ($cont % 2 != 0) {
                $clase = 'lineasPares';
            } else {
                $clase = 'lineasImpares';
            }

            if ($key->gastocomun != 0) {

                if ($key->tipoProveedor == 'proveedor') { //
                    $razon = $this->getProveedoresSelect(true, $key->razonSocial);
                } else if ($key->tipoProveedor == 'profesor') { //
                    $razon = $this->getProfesoresSelect(true, $key->razonSocial);
                } else if ($key->tipoProveedor == 'colaborador') { //
                    $razon = $this->getColaboradoresSelect(true, $key->razonSocial);
                }

                $salida = '<div class="row ' . $clase . ' mb-3 lineasGasto" id="lineaGastoComun_' . $key->idgasto . '">'
                    .    '<div class="form-group row col-md-12 mb-0">'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Tipo gasto</label>'
                    . '<select id="gastoComun' . $key->idgasto . '" type="text" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" class="form-control lineaGasto selectEdit todos" name="tipoGasto">'
                    . '<option>Seleccionar</option>';
                foreach ($tipoGastos as $gastos) {
                    $salida .= '<option value="' . $gastos->idgasto . '" ' . (($gastos->idgasto == $key->tipoGasto) ? 'selected' : '') . '>' . $gastos->descripcion . '</option>';
                }
                $salida .=  '</select>'
                    .       '</div>'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Tipo Proveedor</label>'
                    .             '<select id="proveedorComun' . $key->idgasto . '" data-nueva=0  data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="text" class="form-control lineaGasto selectEdit campotabla tipoProveedor" name="tipoProveedor">'
                    . '<option>Seleccionar</option>';
                foreach ($proveedores as $proveedor) {
                    $salida .= '<option value="' . strtolower($proveedor) . '" ' . ((strtolower($proveedor) == $key->tipoProveedor) ? 'selected' : '') . '>' . $proveedor . '</option>';
                }
                $salida .=  '</select>'
                    .       '</div>'
                    .       ' <div class="col-md-3 col-sm-2">'
                    .           '<label class="labelCampoPres">Razón Social</label>'
                    .       '<select id="razonSocialComun' . $key->idgasto . '" type="text" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '"   class="form-control selectEdit lineaGasto  todos" name="razonSocial">'
                    .       $razon
                    .       '</select>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Importe</label>'
                    .           '<input id="importeGastoComun' . $key->idgasto . '" value="' . $key->importe . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '"   type="number" data-fila="' . $key->idgasto . '" class="text-right  form-control campotabla lineaGasto importeGasto total" name="importe" required>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Cantidad</label>'
                    .           '<input id="cantidadGastoComun' . $key->idgasto . '" value="' . $key->cantidad . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '"  type="number" data-fila="' . $key->idgasto . '" class="form-control campotabla cantidadGasto lineaGasto" name="cantidad" required>'
                    .       '</div>'
                    .     ' <div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">IVA</label>'
                    .           '<input id="ivaGastoComun' . $key->idgasto . '" value="' . $key->iva . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '"  type="number" data-fila="' . $key->idgasto . '" class="form-control campotabla ivaGasto lineaGasto"  name="iva" style="width: 100%;" >'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">IRPF</label>'
                    .               ' <input id="irpfComun' . $key->idgasto . '" value="' . $key->irpf . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="number" data-fila="' . $key->idgasto . '" class="form-control campotabla irpf  lineaGasto" name="irpf" style="width: 100%;" >'
                    .               '</div>'
                    . ' <div class="col-md-1 col-sm-2">'
                    . '<label class="labelCampoPres">Total</label>'
                    . '<input id="totalGastoComun' . $key->idgasto . '" value="' . $key->total . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" data-fila="' . $key->idgasto . '" type="number" class="form-control cambiarTotal lineaGasto" name="total" readonly>'
                    . ' </div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . ' <label class="labelCampoPres">Num. Factura</label>'
                    . '<input id="numFacturaComun' . $key->idgasto . '" value="' . $key->numfacgasto . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="text" class="form-control campotabla lineaGasto" name="numfacgasto" style="width: 100%;">'
                    . '</div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . '<label class="labelCampoPres">Fecha Factura</label>'
                    . '<input id="fechaFacturaComun' . $key->idgasto . '" value="' . $key->fecha . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="date" class="form-control campotabla lineaGasto" name="fecha">'
                    . '</div>';
                // $salida .=      '<div class="col-md-3 col-sm-2">'
                //     .           '<label class="labelCampoPres">IBAN</label>'
                //     .           '<select id="ibanGasto' . $key->idgasto . '" data-nueva=0  data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="text" class="form-control lineaGasto selectEdit todos" name="iban">'
                //     .               '<option disabled selected>Seleccionar</option>';
                // foreach ($ctasBancarias as $cuenta) {
                //     $salida .= '<option value="' . $cuenta->idcuenta . '" ' . (($cuenta->idcuenta == $key->iban) ? 'selected' : '') . '>' . $cuenta->iban . '</option>';
                // }

                $salida .= '<div class="col-md-3 col-sm-2">'
                    . '<label class="labelCampoPres">Concepto</label>'
                    . '<textarea id="editorComun' . $key->idgasto . '"  data-idfactura="' . $key->idgasto . '" data-pk="idfactura" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" name="descripcion" rows="1" cols="10" class="form-control campotabla">"' . strip_tags($key->descripcion) . '"</textarea><br>'
                    . '</div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . '<label class="labelCampoPres">Fecha Pago</label>'
                    . '<input id="fechaCobroComun' . $key->idgasto . '" value="' . $key->fechapago . '" data-idfactura="' . $key->idgasto . '" data-pk="idgasto" data-tabla="gastosaccionproy"  data-fila="' . $key->idgasto . '" type="date" class="form-control lineaGasto campotabla" name="fechapago">'
                    . '</div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . '<label class="labelCampoPres">Acciones</label>'
                    . '<div class="d-lg-flex mb-1">'
                    . '<input class="form-check-input marcaraccion" type="checkbox"  id="checkAccionGastos' . $key->idgasto . '" name="checkAccionGastoNuevo[]" value="' . $key->idgasto . '">'
                    . '<a id="btnEliminarFilaGastosComun' . $key->idgasto . '" class="btn btn-danger mr-1 btnEliminarGasto" data-idgasto="' . $key->idgasto . '" data-gastos="1" data-comun="1" name="btnFacturarFila" title="Eliminar" style="float:right"><i class="fas fa-trash-alt" style="color:white;float:right;"></i></a>'
                    . '</div>'
                    . '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Concepto</label>'
                    .           '<div>'
                    .               '<a class="btn btn-secondary text-white repartirGastos" id="repartirGastos' . $key->idgasto . '" data-indice="' . $key->idgasto . '">Repartir Gastos <i class="fas fa-chevron-down" style="color:white;"></i></a>'
                    .           '</div>'
                    .       '</div>'
                    .       '<div class="col-md-12 col-sm-12 mt-2 mb-4 row" id="contRepartirGastos' . $key->idgasto . '" style="display:none;">'
                    . '<form id="addClientesGastos' . $key->idgasto . '" method="POST">';
                foreach ($lineasGastosClientes as $cliente) {
                    $salida .=  '<div class="col-md-12 col-sm-12 mt-2 mb-4 row" name="datosClientes">'
                        . '<div class="col-md-6">'
                        .  '<label class="labelCampoPres">Clientes</label>'
                        . '<input id="cliente' . $cliente->id . '" name="cliente' .  $cliente->id . '"  class="form-control mb-2" value="' .  $cliente->nombreCliente . '" readonly />'
                        . '</div>'
                        . '<div class="col-md-2">'
                        .   '<label class="labelCampoPres">Importe</label>'
                        . '<input type="number" data-posicion="' . $cliente->id . '" data-idfactura="' . $cliente->id . '" data-pk="id" data-tabla="clientesgastosaccionproy" name="importeCliente" data-fila="' . $cliente->id . '" id="importeCliente' . $cont . '"  class="form-control importeCliente campotabla mb-2" value="' . $cliente->importeCliente . '"/>'
                        . '</div>'
                        . '<div class="col-md-4">'
                        .     '<label class="labelCampoPres">Fecha Cobro Cliente</label>'
                        .     '<input type="date" data-posicion="' . $cliente->id . '" data-idfactura="' . $cliente->id . '" data-pk="id" data-tabla="clientesgastosaccionproy" name="fechaPagoCliente" data-fila="' . $cont . '" id="fechaCliente' . $cont . '"  class="form-control fechaCliente campotabla mb-2" value="' . $cliente->fechaPagoCliente . '"/>'
                        .     '<input type="hidden"  name="idEmpresa' . $cont . '"  value="' . $cliente->idEmpresa . '"/>'
                        . '</div>'
                        . '</div>';
                }
                $salida .= '</form>'
                    . '<div class="col-md-1 col-sm-2">'
                    . '<label class="labelCampoPres">Importe Restante</label>'
                    . '<input type="number" id="importeRestante' . $cliente->id . '"  class="form-control" name="importeRestante" readonly >'
                    . '</div>'
                    . '</div>'
                    . '</div>'
                    . '</div>';
                $html .= $salida;
            }
        }

        return $html;
    }

    public function exportarFacturaPorNumFactura($numFactura)
    {
        $datos = $this->ModelProyecto->obtenerDatosFacturaSegunNumFactura($numFactura);

        $datos->nombreFichero = 'factura.pdf';
        generarPdf::documentoPDFExportar('P', 'A4', 'es', true, 'UTF-8', array(0, 0, 0, 0), true, 'documentos/factura', 'factura.php', $datos);
    }

    public function exportarPdfFactura1($idFactura, $tipoFolio)
    {
        $datosFactura = [
            'idFactura' => $idFactura
        ];

        $rpgd = $this->ModeloConfiguracion->obtenerRGPD();
        $datos = $this->ModelProyecto->obtenerDatosFactura($datosFactura);
        $datos->nombreFichero = 'factura.pdf';
        $datos->tipoFolio = $tipoFolio;
        $datos->descripcionRPGD = $rpgd->descripcion;

        generarPdf::documentoPDFExportar('P', 'A4', 'es', true, 'UTF-8', array(0, 0, 0, 0), true, 'documentos/factura', 'factura.php', $datos);
    }

    public function obtenerColaboradorPorCliente()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idCliente" => $_POST['idCliente'],
                "idProyecto" => $_POST['idProyecto']
            ];
        }
        $colaborador = $this->ModelProyecto->obtenerColaboradorAgentePorCliente($datos);
        echo json_encode($colaborador);
    }

    public function obtenerNumeroTotalDeParticipantes()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idProyecto" => $_POST['idProyecto']
            ];
        }
        $participantes = $this->ModelProyecto->obtenerNumeroTotalDeParticipantes($datos);
        echo json_encode($participantes);
    }


    public function buscarDatosDeTodosLosClientes()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idProyecto" => $_POST['idProyecto']
            ];
        }

        $facturasProy = $this->ModelProyecto->obtenerDatosTodosIngresosProyecto($datos["idProyecto"]);
        $ctasBancarias = $this->ModelProyecto->obtenerCuentasBancarias();
        $gastosProyTodos =  $this->ModelProyecto->obtenerDatosTodosGastosProyecto($datos["idProyecto"]);

        $tipoConcepto = [
            'Gestión Formación - Organizador' => 1,
            'Gestión Formación - Autogestión' => 2,
            'Gestión Formación' => 3,
            'Gestión Consultoría' => 4,
            'Gestión Selección' => 5
        ];

        $cont = 1;

        // $html = '<input type="hidden" value="' . $registros->idAccionProy . '" name="idAccionProy" id="idAccionProy">
        // <input type="hidden" value="' . $registros->idAccionPres . '" name="idAccionPres" id="idAccionPres">
        $html = '<p style="color: blue;">Ingresos del proyecto</p>
        <div id="lineasFacturas">
            <div class="d-flex justify-content-start">
                <input type="hidden" id="contadorLineas" value="0">                            
            </div>';



        foreach ($facturasProy as $key) {

            $cont++;

            if ($key->idfactura != null) {



                if ($cont % 2 == 0) {
                    $clase = 'lineasPares';
                } else {
                    $clase = 'lineasImpares';
                }

                $html2 = '<div class="row mb-3 lineaFact ' . $clase . ' lineas" id="lineaFactura_' . $key->idfactura . '">'
                    .    '<div class="form-group row col-md-12 mb-2">'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Cantidad</label>'
                    .           '<input readonly id="cantidad' . $key->idfactura . '" value="' . $key->cantidad . '" '
                    .               'type="number"  step="0.001" class="text-right form-control "'
                    .               'px-0" name="cantidad" required >'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Importe</label>'
                    .           '<input readonly id="importeFactura' . $key->idfactura . '" value="' . $key->importe . '"  type="number" step="0.001" class="text-right form-control px-0" name="importe" required>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">IVA(%)</label>'
                    .           '<input readonly id="iva' . $key->idfactura . '" value="' . $key->iva . '"  type="number" step="0.001" class="text-right form-control px-0" name="iva" required>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Total</label>'
                    .           '<input id="total' . $key->idfactura . '" value="' . $key->total . '"  type="number" step="0.001" class="text-right form-control  px-0" name="total" required readonly>'
                    .       '</div>'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Fecha</label>'
                    .           '<input readonly id="fechaFactura' . $key->idfactura . '" value="' . $key->fechafactura . '"  type="date" class="form-control " name="fechafactura" required>'
                    .       '</div>';
                $html2 .=           '<div class="col-md-3 col-sm-2">'
                    .           '<label class="labelCampoPres">IBAN</label>'
                    .           '<select id="iban' . $key->idfactura . '" type="text" class="form-control " name="iban">'
                    .               '<option disabled selected>Seleccionar</option>';
                foreach ($ctasBancarias as $cuenta) {
                    $html2 .=           '<option  value="' . $cuenta->idcuenta . '" ' . (($cuenta->idcuenta == $key->iban) ? 'selected' : '') . '>' . $cuenta->iban . '</option>';
                }
                $html2 .=               '</select>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Nº Factura</label>'
                    .           '<input id="numFactura' . $key->idfactura . '" value="' . $key->numfactura . '" type="text" class="form-control  px-0 text-center " name="numfactura" style="width: 100%; padding-left:0.15rem;padding-right:0.15rem;" readonly>'
                    .       '</div>'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Fecha Cobro</label>'
                    .           '<input readonly id="fechaCobro' . $key->idfactura . '"value="' . $key->fechacobro . '" type="date" class="form-control " name="fechacobro">'
                    .       '</div>'
                    .       '<div class="col-md-3 col-sm-2">'
                    .           '<label class="labelCampoPres">Tipo concepto</label>'
                    .           '<select id="tipoConcepto' . $key->idfactura . '"  type="text" class="form-control "name="tipoconcepto">'
                    .               '<option disabled selected>Seleccionar</option>';
                foreach ($tipoConcepto as $clave => $value) {
                    $html2 .=           '<option  value="' . $value . '" ' . (($value == $key->tipoconcepto) ? 'selected' : '') . '>' . $clave . '</option>';
                }
                $html2  .=          '</select>'
                    .       '</div>'
                    .       '<div class="col-md-3 col-sm-2">'
                    .           '<label class="labelCampoPres">Concepto</label>'
                    .           '<div>'
                    .               '<a class="btn btn-secondary text-white editarConcepto" id="editarConcepto' . $key->idfactura . '" data-idfactura="' . $key->idfactura . '" data-indice="' . $key->idfactura . '">Editar concepto <i class="fas fa-chevron-down" style="color:white;"></i></a>'
                    .           '</div>'
                    .       '</div>'
                    .       '<div class="col-md-6 col-sm-2">'
                    .           '<label class="labelCampoPres">Nombre</label>'
                    .          '<input value="' . $key->NOMBREJURIDICO . '" type="text"  class="form-control" name="nombreCliente" readonly>'
                    .       '</div>'
                    .        '<div class="col-md-12 col-sm-12 mt-2 mb-4" id="contEditorConcepto' . $key->idfactura . '"  style="display:none;">'
                    .           '<textarea data-idfactura="' . $key->idfactura . '" data-pk="idfactura" data-tabla="facturascabecera" id="editor' . $key->idfactura . '"  name="concepto" rows="1" cols="10" class="form-control campotabla">' . $key->concepto . '</textarea><br>'
                    .        '</div>'
                    .   '</div>'
                    . '</div>';
                $html .= $html2;
            }
        }

        $html .= '</div>';

        $html .= '<p style="color: blue;" class="mt-5">Gastos del Proyecto</p>'
            .     '<div class="LineaGastos" id="contenedorLineasGastos">'
            .       '<div class="d-flex justify-content-start">'
            .           '<input type="hidden" id="lineasGastos" value="0">'
            .       '</div>'
            .     '</div>';
        // $retorno = $this->ModelProyecto->buscarDatosDeTodosLosClientes($datos);

        $lineasGastos = $this->pintarGastosProyectoTodos($gastosProyTodos);

        $emails = $this->pintarTablaEmails($datos["idProyecto"]);

        $respuesta = [
            "html" => $html,
            "htmlGastos" => $lineasGastos,
            "htmlemails" => $emails
        ];

        echo json_encode($respuesta);
    }

    public function pintarTablaEmails($idProyecto)
    {

        $emails = $this->ModelProyecto->obtenerEmailsByIdProyecto($idProyecto);


        $salida = '';

        $salida .= '<table class="table">'
            . '<thead>'
            . ' <tr>'
            . ' <th scope="col" class="text-center">Cliente</th>'
            . '<th scope="col" class="text-center">Asunto</th>'
            . ' <th scope="col" class="text-center">Nombre Usuario</th>'
            . ' <th scope="col" class="text-center">Fecha</th>'
            . ' <th scope="col" class="text-center">Detalle</th>'
            . ' </tr>'
            . ' </thead>'
            . '<tbody> ';
        foreach ($emails as $key) {
            $salida .=  '<tr>'
                . '<td class="text-center">' . $key->NOMBREJURIDICO . '</td>'
                . '<td class="text-center">' . $key->subject . '</td>'
                . '<td class="text-center">' . $key->Nombre . '</td>'
                . '<td class="text-center">' . date("d-m-Y", strtotime($key->fecha)) . '</td>'
                . '<td class="text-center"><a href="#Detalle"  class="detalleEmail btn btn-xs btn-primary" data-id="' . $key->idEmail . '" type="button" data-toggle="modal" title="Detalle"><i class="far fa-eye"></i></a></td>'
                . '</tr>';
        };
        $salida .= '</tbody>'
            . '</table> ';



        return $salida;
    }

    public function pintarGastosProyectoTodos($gastosProyTodos)
    {

        $tipoGastos = $this->ModelProyecto->obtenerTipoGastosGenerales();


        $proveedores = [
            "Proveedor", "Profesor", "Colaborador"
        ];

        $html = '';

        $cont = 1;

        foreach ($gastosProyTodos as $key) {

            if ($key->idgasto != null) {
                $cont++;

                if ($cont % 2 == 0) {
                    $clase = 'lineasPares';
                } else {
                    $clase = 'lineasImpares';
                }



                if ($key->tipoProveedor == 'proveedor') { //
                    $razon = $this->getProveedoresSelect(true, $key->razonSocial);
                } else if ($key->tipoProveedor == 'profesor') { //
                    $razon = $this->getProfesoresSelect(true, $key->razonSocial);
                } else if ($key->tipoProveedor == 'colaborador') { //
                    $razon = $this->getColaboradoresSelect(true, $key->razonSocial);
                }

                $salida = '<div class="row mb-3 ' . $clase . ' lineasGasto" id="lineaGasto_' . $key->idgasto . '">'
                    .    '<div class="form-group row col-md-12 mb-0">'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Tipo gasto</label>'
                    . '<select id="gasto' . $key->idgasto . '" type="text" class="form-control " name="tipoGasto">'
                    . '<option>Seleccionar</option>';
                foreach ($tipoGastos as $gastos) {
                    $salida .= '<option value="' . $gastos->idgasto . '" ' . (($gastos->idgasto == $key->tipoGasto) ? 'selected' : '') . '>' . $gastos->descripcion . '</option>';
                }
                $salida .=  '</select>'
                    .       '</div>'
                    .       '<div class="col-md-2 col-sm-2">'
                    .           '<label class="labelCampoPres">Tipo Proveedor</label>'
                    .             '<select id="proveedor' . $key->idgasto . '" type="text" class="form-control " name="tipoProveedor">'
                    . '<option>Seleccionar</option>';
                foreach ($proveedores as $proveedor) {
                    $salida .= '<option value="' . strtolower($proveedor) . '" ' . ((strtolower($proveedor) == $key->tipoProveedor) ? 'selected' : '') . '>' . $proveedor . '</option>';
                }
                $salida .=  '</select>'
                    .       '</div>'
                    .       ' <div class="col-md-3 col-sm-2">'
                    .           '<label class="labelCampoPres">Razón Social</label>'
                    .       '<select id="razonSocial' . $key->idgasto . '" type="text" class="form-control " name="razonSocial">'
                    .       $razon
                    .       '</select>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Importe</label>'
                    .           '<input readonly id="importeGasto' . $key->idgasto . '" value="' . $key->importe . '" class="text-right  form-control " name="importe" required>'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">Cantidad</label>'
                    .           '<input readonly id="cantidadGasto' . $key->idgasto . '" value="' . $key->cantidad . '"   type="number" data-fila="' . $key->idgasto . '" class="form-control" name="cantidad" required>'
                    .       '</div>'
                    .     ' <div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">IVA</label>'
                    .           '<input readonly id="ivaGasto' . $key->idgasto . '" value="' . $key->iva . '" type="number" data-fila="' . $key->idgasto . '" class="form-control"  name="iva" style="width: 100%;" >'
                    .       '</div>'
                    .       '<div class="col-md-1 col-sm-2">'
                    .           '<label class="labelCampoPres">IRPF</label>'
                    .               ' <input readonly id="irpf' . $key->idgasto . '" value="' . $key->irpf . '"  type="number" data-fila="' . $key->idgasto . '" class="form-control" name="irpf" style="width: 100%;" >'
                    .               '</div>'
                    . ' <div class="col-md-1 col-sm-2">'
                    . '<label class="labelCampoPres">Total</label>'
                    . '<input id="totalGasto' . $key->idgasto . '" value="' . $key->total . '"  type="number" class="form-control " name="total" readonly>'
                    . ' </div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . ' <label class="labelCampoPres">Num. Factura</label>'
                    . '<input readonly id="numFactura' . $key->idgasto . '" value="' . $key->numfacgasto . '" type="text" class="form-control " name="numfacgasto" style="width: 100%;">'
                    . '</div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . '<label class="labelCampoPres">Fecha Factura</label>'
                    . '<input readonly id="fechaFactura' . $key->idgasto . '" value="' . $key->fecha . '"  type="date" class="form-control  " name="fecha">'
                    . '</div>'
                    . '<div class="col-md-3 col-sm-2">'
                    . '<label class="labelCampoPres">Concepto</label>'
                    . '<textarea id="editor' . $key->idgasto . '"  data-idfactura="' . $key->idgasto . '"  name="descripcion" rows="1" cols="10" class="form-control ">"' . strip_tags($key->descripcion) . '"</textarea><br>'
                    . '</div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . '<label class="labelCampoPres">Fecha Pago</label>'
                    . '<input readonly id="fechaCobro' . $key->idgasto . '" value="' . $key->fechapago . '" type="date" class="form-control  " name="fechapago">'
                    . '</div>'
                    . '<div class="col-md-2 col-sm-2">'
                    . '<label class="labelCampoPres">Acciones</label>'
                    . '<div class="d-lg-flex mb-1">'
                    . '<input class="form-check-input marcaraccion" type="checkbox" data-idaccion="' . $key->idgasto . '" id="checkAccionGastos' . $key->idgasto . '" name="checkAccionGastoNuevo[]" value="' . $key->idgasto . '">'
                    .          '<input value="' . $key->NOMBREJURIDICO . '" type="text"  class="form-control" name="nombreCliente" readonly>'
                    . '</div>'
                    . '</div>'
                    . '</div>'
                    . '</div>';
                $html .= $salida;
            }
        }


        return $html;
    }






    public function getProfesores()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "profesor" => $_POST['profesor'],
            ];
        }
        $profesor = $this->ModelProyecto->obtenerDatosProfesor($datos);
        echo json_encode($profesor);
    }

    public function obtenerNumeroParticipantes()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                "idAccionProy" => $_POST['idAccionProy'],
            ];
        }
        $numParticipantes = $this->ModelProyecto->obtenerNumeroParticipantes($datos);
        echo json_encode($numParticipantes);
    }

    public function generarFactura()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $datos = [
                'idAccionProy' => $_POST['idAccionProy'],
                'idPresupuesto' => $_POST['idPresupuesto'],
                'idEmpresa' => $_POST['idEmpresa'],
                'importeFactura' => $_POST['importeFactura'],
                'cantidad' => $_POST['cantidad'],
                'iva' => $_POST['iva'],
                'total' => $_POST['total'],
                'fechaFactura' => $_POST['fecha'],
                'fechaCobro' => $_POST['fechaCobro'],
                'iban' => $_POST['iban'],
                'predefinido' => $_POST['predefinido'],
                'concepto' => $_POST['hmtlConcepto'],
                'tipoConcepto' => $_POST['tipoConcepto'],
                'tipoFolio' => $_POST['tipoFolio']
            ];

            //crea la cabecera de la factura
            $datosFactura = $this->ModelProyecto->creaCabeceraFactura($datos);
            if ($datosFactura > 0) {
                $retorno = $datosFactura;
            } else {
                $retorno = 0;
            }
        } else {
            $retorno = 0;
        }

        echo $retorno;
    }

    public function obtenerConcepto()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $datos = [
                'idFact' => $_POST['idFact'],
            ];
        }

        $datosFactura = $this->ModelProyecto->obtenerConcepto($datos);

        echo json_encode($datosFactura);
    }

    public function actualizarFactura()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                'importeFactura' => $_POST['importeFactura'], //
                'cantidad' => $_POST['cantidad'], //
                'iva' => $_POST['iva'],
                'total' => $_POST['total'],
                'fechaFactura' => $_POST['fecha'],
                'fechaCobro' => $_POST['fechaCobro'],
                'iban' => $_POST['iban'],
                'idFactura' => $_POST['idFactura'],
                'concepto' => $_POST['concepto']
            ];
        }
        //verificar si hay saldo por facturar
        //$validaSaldoFacturable = $this->ModelProyecto->validarSaldoPorFacturarParaAccion($datos);
        //si viene true, se puede hacer otra factura
        /*echo"valida: ";
            print_r($validaSaldoFacturable);
            die;*/
        $validaSaldoFacturable = 'true';
        if ($validaSaldoFacturable == 'true') {
            //crea la cabecera de la factura
            $datosFactura = $this->ModelProyecto->actualizarFactura($datos);
            if ($datosFactura['true']) {
                $retorno = $datosFactura['true'];
            } else {
                $retorno = 'false';
            }
        } else { //si viene false es que la factura que se quiere generar excede el saldo por facturar
            $retorno = 'false';
        }


        echo json_encode($retorno);
    }



    public function enviarEMailYFicheroPfd()
    {

        session_start();
        /*
        echo"entra al controlador";        
        $emails = $_POST['emails'];
        $numFactura = $_POST['numFactura'];        
        var_dump($emails);
        var_dump($numFactura);

        die;
        */

        if ($_POST['numFactura'] && $_POST['emails']) {

            //genero la factura pdf para envío
            $datosFactura = $this->ModelProyecto->obtenerDatosFacturaSegunNumFactura($_POST['numFactura']);
            $datosFactura->tipofolio = $_POST['tipoFolio'];

            $attachment = generarPdf::documentoPDFParaEmail('P', 'A4', 'es', true, 'UTF-8', array(0, 0, 0, 0), true, 'documentos/factura', 'factura.php', $datosFactura);

            //contruyo array con datos de envío:
            $nombreRemitente = $_SESSION['nombre'];
            $emailRemitente = 'info@dataleanmakers.es';
            $asunto = $_POST['asunto'];
            $emailsDestino = $_POST['emails'];

            if ($emailsDestino) {
                $JSON = $emailsDestino;
            } else {
                $JSON = [];
            }

            $emailsJSON = json_encode($JSON);

            //construyo cuerpo de mensaje
            $message = $_POST['mensaje'];

            $envio = enviarEmail::enviarEmailDestinatario($nombreRemitente, $emailRemitente, $emailsDestino, $asunto, $message, $attachment, $datosFactura);


            $this->insertarDatosEmail($datosFactura, $asunto, $message, $emailsJSON);

            if ($envio) {
                // si se ha enviado que guarde los sgtes datos: email de usuario logado, cuerpo del mensaje, asunto, fecha de envío, destinatarios, y un vínculo para descargar la factura
                $retorno = 1;
            } else {
                $retorno = 0;
            }
        } else {
            $retorno = 0;
        }
        echo $retorno;
    }

    public function insertarDatosEmail($datosFactura, $asunto, $message, $emailsJSON)
    {
        $this->ModelProyecto->insertarDatosEmail($datosFactura, $asunto, $message, $emailsJSON);
    }

    public function agregarProyecto()
    {
        $this->iniciar();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                'nombreProyecto' => trim($_POST['nombreProyecto']),
                'tipoProyecto' => trim($_POST['tipoProyecto']),
                'descripcion' =>  trim($_POST['descripcion']),
                'estadoProyecto' => trim($_POST['estadoProyecto']),
                'clienteProyecto' => trim($_POST['clienteProyecto']),
                'profesor' => trim($_POST['profesor']),
                'colaborador' => trim($_POST['colaborador']),
                'observacionesGenerales' => trim($_POST['observacionesGenerales']),
                'accionFormativa' => trim($_POST['accionFormativa']),
                'tipoAccionFormativa' => trim($_POST['tipoAccionFormativa']),
                'areaFormativa' => trim($_POST['areaFormativa']),
                'modalidadFormativa' => trim($_POST['modalidadFormativa']),
                'objetivo' => trim($_POST['objetivo']),
                'contenido' => trim($_POST['contenido']),
                'metodologia' => trim($_POST['metodologia']),
                'observacionesAccion' => trim($_POST['observacionesAccion'])
            ];



            if ($this->ModelProyecto->agregarProyecto($datos)) {
                redireccionar('/proyecto/listaProyectos');
            } else {
                die('Algo salio mal');
            }
        } else {
            $datos = [
                'nombreProyecto' => '',
                'tipoProyecto' => '',
                'descripcion' =>  '',
                'estadoProyecto' => '',
                'clienteProyecto' => '',
                'profesor' => '',
                'colaborador' => '',
                'observacionesGenerales' => '',
                'accionformativa' => '',
                'tipoAccionFormativa' => '',
                'areaFormativa' => '',
                'modalidadFormativa' => '',
                'objetivo' => '',
                'contenido' => '',
                'metodologia' => '',
                'observacionesAccion' => ''
            ];
            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {

                $this->vista('proyecto/listaProyectos');
            }
        }
    }


    public function confirmarPrecioFinal()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                'precioFinal' => $_POST['precioFinal'],
                'idAccionProy' => $_POST['idAccionProy'],
            ];
        }
        $update = $this->ModelProyecto->actualizarPrecioFinal($datos);
        echo json_encode($update);
    }

    public function agregarCosteAcccionProyecto()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                'idAccionProy' => $_POST['idAccionProy'],
                'clasificacion' => $_POST['clasificacion'],
                'tipoCoste' => $_POST['tipoCoste'],
                'importeFactura' => $_POST['importeFactura'],
                'cantidad' => $_POST['cantidad'],
                'iva' => $_POST['iva'],
                'total' => $_POST['total'],
                'fecha' => $_POST['fecha'],
                'fechaCobro' => $_POST['fechaCobro'],
                'irpf' => $_POST['irpf'],
                'numFacCoste' => $_POST['numFacCoste']
            ];
        }
        $update = $this->ModelProyecto->agregarCosteAcccionProyecto($datos);
        echo json_encode($update);
    }

    public function agregarGastoAcccionProyecto()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $datos = [
                'idAccionProy' => $_POST['idAccionProy'],
                'tipoGasto' => $_POST['tipoGasto'],
                'tipoProveedor' => $_POST['tipoProveedor'],
                'razonSocial' => $_POST['razonSocial'],
                'importeGasto' => $_POST['importeGasto'],
                'cantidadGasto' => $_POST['cantidadGasto'],
                'ivaGasto' => $_POST['ivaGasto'],
                'irpf' => $_POST['irpf'],
                'totalGasto' => $_POST['totalGasto'],
                'fechaGasto' => $_POST['fechaGasto'],
                'numFacGasto' => $_POST['numFacGasto'],
                'descripcion' => $_POST['descripcion'],
                'fechaPago' => $_POST['fechaPago'],
                'iban' => $_POST['iban'],
                'comun' => $_POST['comun']
            ];
        }
        $ultimoId = $this->ModelProyecto->agregarGastoAcccionProyecto($datos);

        if ($_POST['comun'] == 1) {


            $datos = [];
            foreach ($_POST['form'] as $row) {
                $datos[$row['name']] = $row['value'];
            }

            for ($i = 0; $i <= $datos['contadorFilasClientes']; ++$i) {
                $datosLinea = [];

                $campos = ['idGasto', 'idEmpresa', 'nombreCliente', 'importeCliente', 'fechaPagoCliente'];
                $valores = ["'" . $ultimoId . "'", "'" . $datos['idEmpresa' . $i] . "'", "'" . $datos['cliente' . $i] . "'", "'" . $datos['importe' . $i] . "'", "'" . $datos['fechacobro' . $i] . "'"];

                $datosLinea = [
                    'campos' => implode(',', $campos),
                    'valores' => implode(',', $valores),
                ];
                $this->ModelProyecto->insertarClientesGastosComun($datosLinea);
            }
        }

        echo json_encode($ultimoId);
    }


    public function getProveedoresSelect($return = false, $razonSocial = 0)
    {
        $proveedores = $this->ModelProyecto->obtenerProveedoresSelect();
        $salida = "<option selected disabled>Seleccionar.....</option>";

        foreach ($proveedores as $row) {

            $salida .= '<option value="' . $row->id . '" ' . (($razonSocial == $row->id) ? 'selected' : '') . '  >' . $row->nombre . ' </option>';
        }
        if ($return) return $salida;
        echo $salida;
    }

    public function getProfesoresSelect($return = false, $razonSocial = 0)
    {
        $profesores = $this->ModelProyecto->obtenerProfesoresSelect();
        $salida = "<option selected disabled>Seleccionar.....</option>";

        foreach ($profesores as $row) {

            $salida .= '<option value="' . $row->id . '" ' . (($razonSocial == $row->id) ? 'selected' : '') . '  >' . $row->nombre . '</option>';
        }
        if ($return) return $salida;
        echo $salida;
    }

    public function getColaboradoresSelect($return = false, $razonSocial = 0)
    {
        $colaboradores = $this->ModelProyecto->obtenerColaboradoresSelect();
        $salida = "<option selected disabled>Seleccionar.....</option>";

        foreach ($colaboradores as $row) {

            $salida .= '<option value="' . $row->id . '" ' . (($razonSocial == $row->id) ? 'selected' : '') . '  >' . $row->nombre . '</option>';
        }
        if ($return) return $salida;
        echo $salida;
    }

    public function actualizarFichaProyecto()
    {

        $this->iniciar();

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //$diasImparticion = $_POST['dia'];

            $salida = "(";
            if (!empty($_POST['dia'])) {
                $cadena = $_POST['dia'];

                for ($i = 0; $i < count($cadena); $i++) {
                    if ($i != (count($cadena) - 1)) {
                        $salida .=  $cadena[$i] . ",";
                    } else {
                        $salida .=  $cadena[$i] . ")";
                    }
                }
            }

            /*
                $cadena = '';
                foreach ($diasImparticion as $key => $value) {
                    $cadena .= $value.',';
                }
            */


            $data = [
                "idPresupuesto" => $_POST['idPresupuesto'],
                "idProyecto" => $_POST['idProyecto'],
                "idAccion" => $_POST['idAccion'],
                "fechaPres" => $_POST['fechaPres'],
                "servicio" => $_POST['servicio'],
                "fechaInicio" => $_POST['fechaInicio'],
                "fechaIniOriginal" => $_POST['fechaIniOriginal'],
                "fechaFin" => $_POST['fechaFin'],
                "fechaIniFun" => $_POST['fechaIniFun'],
                "fechaFinFun" => $_POST['fechaFinFun'],
                "mesBonif" => $_POST['mesBonif'],

                "mananaIni" => $_POST['mananaIni'],
                "mananaFin" => $_POST['mananaFin'],
                "tardeIni" => $_POST['tardeIni'],
                "tardeFin" => $_POST['tardeFin'],
                "obsHorario" => $_POST['obsHorario'],
                "hTeleformacion" => $_POST['hTeleformacion'],
                "hPresencial" => $_POST['hPresencial'],
                "participantes" => $_POST['participantes'],
                "obsFichaProy" => $_POST['obsFichaProy'],
                "dias" => $salida
            ];

            if ($_POST['importPlantilla'] && isset($_FILES['plantillaParticipantes']['name'])) {
                /*echo "entra al controlador2";
                print_r($_FILES);
                print_r($_POST['idProyecto']);*/
                $importados = $this->subirImportarPlantillaParticipantes($_POST['idProyecto'], $_FILES, $_POST['descripcionFichero']);

                if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                    redireccionar('/login');
                } else {
                    $variable = '<script type="text/javascript">window.location.href="' . RUTA_URL . '/Proyecto/fichaProyecto/' . $data['idProyecto'] . '/2"</script>';
                    echo $variable;
                }
            } else if ($this->ModelProyecto->updateFichaProyecto($data)) {
                //$id = $data['idPresupuesto']."_".$data['idAccion']."_".$newDateIni;

                if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                    redireccionar('/login');
                } else {
                    $variable = '<script type="text/javascript">window.location.href="' . RUTA_URL . '/Proyecto/fichaProyecto/' . $data['idProyecto'] . '"</script>';
                    echo $variable;
                }
            } else {
                die('Algo salio mal');
            }
        } else {
            $datos = [
                "id" => "",
            ];

            if (!isset($_SESSION['autorizado']) || $_SESSION['autorizado'] != 1) {
                redireccionar('/login');
            } else {
                $this->vista('/proyecto', $datos);
            }
        }
    }



    public function subirImportarPlantillaParticipantes()
    {

        // $id='', $files=[], $desc=''
        /*echo"entra a subirImportar";
        print_r($id);
        echo"<br>";
        print_r($files);
        echo"<br>";
        print_r($desc);*/

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            //subir el fichero        
            $nombre = $_FILES['archivo']['name'];
            $guardado = $_FILES['archivo']['tmp_name'];
            $carpeta = 'participantes';
            $insert = $this->uploadFile($nombre, $guardado, $_POST['idProyecto'], $_FILES['archivo']['type'],  $_POST['nombre'], $carpeta);
            //die;
            //$insert es el nombre del archivo
            if (isset($insert) && $insert != '') {
                //si lo ha subido entonces que haga la importación
                /*echo"lo ha subido";
            print_r($insert);   */

                //si ha subido el fichero, que los lea los datos del fichero
                $importados = $this->obtenerDatosFicheroExcel($_POST['idProyecto'], $insert);
                return $importados;
                //die;
            }
        }
    }

    public function uploadFile($nombre, $guardado, $id, $tipo, $descripcion, $carpeta)
    {
        /* echo"<br><br><br>";
        echo"entra a uploadFile";
        echo"<br><br><br>";
        print_r($nombre);
        echo"<br>";print_r($guardado);
        echo"<br>";print_r($id);
        echo"<br>";print_r($tipo);
        echo"<br>";print_r($descripcion);
        echo"<br>";*/


        if (!file_exists(DOCUMENTOS_PRIVADOS . $carpeta)) {
            mkdir(DOCUMENTOS_PRIVADOS . $carpeta, 0777, true);
            if (file_exists(DOCUMENTOS_PRIVADOS . $carpeta)) {
                if (move_uploaded_file($guardado, DOCUMENTOS_PRIVADOS . $carpeta . '/' . $nombre)) {
                    $confirma = true;
                } else {
                    $confirma = false;
                }
            }
        } else {
            if (move_uploaded_file($guardado, DOCUMENTOS_PRIVADOS . $carpeta . '/' . $nombre)) {
                $confirma = true;
            } else {
                $confirma = false;
            }
        }
        // if ($confirma == true) {
        //     if ($carpeta == 'participantes') {
        //         $insert = $this->ModelProyecto->insertarRegistroFichero($nombre, $id, $tipo, $descripcion);
        //     } else if ($carpeta == 'proyectos') {
        //         $insert = $this->ModelProyecto->insertarRegistroFicheroProyecto($nombre, $id, $tipo, $descripcion);
        //     }

        //     return $insert;
        // } else {
        //     return false;
        // }

        return $nombre;
    }

    public function obtenerDatosFicheroExcel($idProyecto, $name)
    {
        // echo "entra a prueba";

        $rutaArchivo = DOCUMENTOS_PRIVADOS . "participantes/" . $name;

        echo $rutaArchivo;

        $documento = IOFactory::load($rutaArchivo);



        //$hojaDeProductos = $documento->getSheet(0);
        $sheet = $documento->getSheet(0);

        $numeroParticipantes = 0;
        $particpantesImportados = 0;
        $arr_errors = [];
        $arr_data_produts = [];

        //8 es la fila donde empiezan los datos en el fichero excel
        foreach ($sheet->getRowIterator(8) as $row) {
            $dni = trim($sheet->getCellByColumnAndRow(2, $row->getRowIndex()));
            $nombre = trim($sheet->getCellByColumnAndRow(3, $row->getRowIndex()));
            $apellido1 = trim($sheet->getCellByColumnAndRow(4, $row->getRowIndex()));
            $apellido2 = trim($sheet->getCellByColumnAndRow(5, $row->getRowIndex()));
            $fechaNacimiento = trim($sheet->getCellByColumnAndRow(6, $row->getRowIndex()));
            $email = trim($sheet->getCellByColumnAndRow(7, $row->getRowIndex()));
            $Telefono = trim($sheet->getCellByColumnAndRow(8, $row->getRowIndex()));
            $numSocial = trim($sheet->getCellByColumnAndRow(9, $row->getRowIndex()));
            $sexo = trim($sheet->getCellByColumnAndRow(10, $row->getRowIndex()));
            $nivelEstudio = trim($sheet->getCellByColumnAndRow(11, $row->getRowIndex()));
            $catProfesional = trim($sheet->getCellByColumnAndRow(12, $row->getRowIndex()));
            $grupoCotizacion = trim($sheet->getCellByColumnAndRow(13, $row->getRowIndex()));
            $discapacidad = trim($sheet->getCellByColumnAndRow(14, $row->getRowIndex()));
            $terrorismo = trim($sheet->getCellByColumnAndRow(15, $row->getRowIndex()));
            $violenciaGenero = trim($sheet->getCellByColumnAndRow(16, $row->getRowIndex()));
            $fechaAlta = trim($sheet->getCellByColumnAndRow(17, $row->getRowIndex()));
            $numPatronal = trim($sheet->getCellByColumnAndRow(18, $row->getRowIndex()));


            if ($dni == '' || $nombre == '' || $apellido1 == '' || $apellido2 == '')
                continue;

            $data_product = [
                'dni' => $dni, 'nombre' => $nombre, 'apellido1' => $apellido1, 'apellido2' => $apellido2, 'fechaNacimiento' => $fechaNacimiento, 'email' => $email,
                'Telefono' => $Telefono, 'numSocial' => $numSocial, 'sexo' => $sexo, 'nivelEstudio' => $nivelEstudio, 'catProfesional' => $catProfesional,
                'grupoCotizacion' => $grupoCotizacion, 'discapacidad' => $discapacidad, 'terrorismo' => $terrorismo, 'violenciaGenero' => $violenciaGenero, 'fechaAlta' => $fechaAlta,
                'numPatronal' => $numPatronal, 'idProyecto' => $idProyecto
            ];
            $arr_data_produts[] = $data_product;
            $numeroParticipantes++;
        }
        echo "imprime array datos";
        print_r($arr_data_produts);
        //die;

        $participantesImportados = $this->ModelProyecto->insertarParticipantesBDDesdeExcel($arr_data_produts);
        $data['participantesImportados'] = $participantesImportados;
        $data['numeroParticipantes'] = $numeroParticipantes;

        echo "Total de Trabajadores leidos: " . $data['numeroParticipantes'];
        echo "Total de Trabajadores importados: " . $data['participantesImportados'];
        return $data;
    }

    public function crudParticipantes()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // $datos = [
            //     'idProyecto' => $_POST['idProyecto'],
            //     'docIdentidad' => $_POST['docIdentidad'],
            //     'nombre' => $_POST['nombre'],
            //     'apellido1' => $_POST['apellido1'],
            //     'apellido2' => $_POST['apellido2'],
            //     'idEmpresa' => $_POST['idEmpresa'],
            //     'id' => $_POST['alumno_id'],
            //     'opcion' => $_POST['opcion'],
            //     'idEmpleado' => $_POST['idEmpleado']
            // ];



            if ($_POST['opcion'] == 1 || $_POST['opcion'] == 2) {
                $datosNuevo = [];
                foreach ($_POST['form'] as $row) {
                    $datosNuevo[$row['name']] = $row['value'];
                }
            }

            if ($_POST['opcion'] == 1) {
                $retorno = $this->ModelProyecto->adicionarParticipanteNuevo($datosNuevo, $_POST['idProyecto']);
            } else if ($_POST['opcion'] == 2) {
                $retorno = $this->ModelProyecto->actualizarParticipante($datosNuevo,$_POST['idParticipante']);
            } else if ($_POST['opcion'] == 3) {
                $retorno = $this->ModelProyecto->eliminarParticipante($_POST);
            } else if ($_POST['opcion'] == 4) {
                $retorno = $this->ModelProyecto->listarParticipantes($_POST['idProyecto']);
            } else if ($_POST['opcion'] == 5) {
                $retorno = $this->ModelProyecto->agregarParticipantesDeBD($_POST);
            }
            print json_encode($retorno, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
            return $retorno;
        }
    }

    //--------------------------------------------------------CONSTRUYENFO UPLOAD DOCS PROYECTO
    public function crudFicherosProyecto()
    {

        if (isset($_POST) || isset($_FILES['archivo']['name'])) {

            $datos = [
                'idProyecto' => $_POST['idProyecto'],
                'opcion' => $_POST['opcion'],
                'idDocumento' => $_POST['docProy_id']
            ];
            if ($datos['opcion'] == 1) {
                echo "entra al controlador con opcion1";
                echo "<br>";
                print_r($_POST);
                echo "<br>";
                echo "files: ";
                print_r($_FILES);

                if (isset($_FILES['archivo']['name']) && $_FILES['archivo']['tmp_name'] != '') {
                    $nombreAnt = $_FILES['archivo']['name'];
                    $lastDoc = $this->ModelProyecto->obtenerUltimoIdDocProyecto();
                    $nombre = $lastDoc . "_" . $nombreAnt;
                    $guardado = $_FILES['archivo']['tmp_name'];
                    $carpeta = 'proyectos';

                    $retorno = $this->uploadFile($nombre, $guardado, $datos['idProyecto'], $_FILES['archivo']['type'], $_POST['nombre'], $carpeta);
                    echo "<br>";
                    echo "imprime retorno de uploadFile";
                    print_r($retorno);
                }
                //$retorno = $this->ModelProyecto->adicionarDocumentoNuevo($datos);
                /*}else if ($datos['opcion']==2){
            $retorno = $this->ModelProyecto->actualizarParticipante($datos);
        */
            } else if ($datos['opcion'] == 3) {

                $retorno = $this->ModelProyecto->eliminarDocsProyecto($datos);
            } else if ($datos['opcion'] == 4) {
                $retorno = $this->ModelProyecto->listarDocsProyecto($datos);
            }/*else if ($datos['opcion']==5){
            $retorno = $this->ModelProyecto->agregarParticipantesDeBD($datos);
        }*/

            print json_encode($retorno, JSON_UNESCAPED_UNICODE); //enviar el array final en formato json a JS
            //return $retorno;
        }
    }



    //---------------------------------------------------------------------



    public function asignarProfesorProyecto()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datos = [
                'idProfesor' => $_POST['idProfesor'],
                'idProyecto' => $_POST['idProyecto'],
                'profInterno' => $_POST['profInterno'],
                'obsProfesor' => $_POST['obsProfesor']
            ];
        }
        $update = $this->ModelProyecto->asignarProfesorProyecto($datos);
        echo json_encode($update);
    }

    public function descargarDocumentosProyecto($nameDoc)
    {
        $this->iniciar();
        if ($nameDoc == '1') {
            $filename = 'Parte de Firmas  FUNDACION con lopd 2018 slogo.doc';
        } else if ($nameDoc == '2') {
            $filename = 'Parte de Firmas  FUNDACION con lopd 2018.doc';
        } else if ($nameDoc == '3') {
            $filename = 'Recibí material 2018 slogo.doc';
        } else if ($nameDoc == '4') {
            $filename = 'Recibí material 2018.doc';
        } else if ($nameDoc == '5') {
            $filename = 'Recibí material 2018 slogo.doc';
        } else if ($nameDoc == '6') {
            $filename = 'Recibí diploma 2018.doc';
        }
        //$filename = $nameDoc."";
        $file = DOCUMENTOS_PRIVADOS . "formulariosProyecto/" . $filename;
        $mime = mime_content_type($file);
        header('Content-disposition: attachment; filename=' . str_replace(" ", '_', $filename));
        header('Content-type: ' . $mime);
        readfile($file);
    }

    public function descargarFicherosProyecto($nameDoc)
    {
        $this->iniciar();
        $file = DOCUMENTOS_PRIVADOS . "proyectos/" . $nameDoc;
        $mime = mime_content_type($file);
        header('Content-disposition: attachment; filename=' . str_replace(" ", '_', $nameDoc));
        header('Content-type: ' . $mime);
        readfile($file);
    }

    public function actualizarHorasEnPresupuestoYProyecto()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idProyecto = $_POST['idProyecto'];
            $horas = $_POST['horas'];
            $presenciales = $_POST['presenciales'];
            $teleformacion = $_POST['teleformacion'];
            $aulaVirtual = $_POST['aulaVirtual'];
        }

        $resultado = $this->ModelProyecto->actualizarHorasEnPresupuestoYProyecto($idProyecto, $horas, $presenciales, $teleformacion, $aulaVirtual);
        print $resultado;
    }


    public function actualizarParticipantesEnPresupuesto()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idAccionPres = $_POST['idAccionPres'];
            $participantes = $_POST['participantes'];
        }

        $resultado = $this->ModelProyecto->actualizarParticipantesEnPresupuesto($idAccionPres, $participantes);
        print $resultado;
    }

    public function agregarLineaFactura()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $total = $_POST['total'];
            $idAccionProy = $_POST['idAccionProy'];

            $datos = [
                "cantidad" => '',
                "importe" => '',
                "iva" => '',
                "totalIngreso" => '',
                "fecha" => '',
                "iban" => '',
                "fechaCobro" => '',
                "concepto" => '',
            ];

            if ($_POST['negativo'] == 1) {

                $cptoNegativo = '<p><b><u>FACTURA RECTIFICATIVA &nbsp; de la factura Nº: &nbsp; &nbsp;</u></b>' . $_POST['numFactura'] . '</p>
                                <br>'
                    . $_POST['concepto'];

                $datos = [
                    "cantidad" => $_POST['cantidad'],
                    "importe" => $_POST['importe'],
                    "iva" => $_POST['iva'],
                    "totalIngreso" => $_POST['totalIngreso'],
                    "fecha" => $_POST['fecha'],
                    "iban" => $_POST['iban'],
                    "fechaCobro" => $_POST['fechaCobro'],
                    //"concepto" => $_POST['concepto'],
                    "concepto" => $cptoNegativo
                ];
            }



            $order = $total + 1;
            $ctasBancarias = $this->ModelProyecto->obtenerCuentasBancarias();


            if ($order % 2 != 0) {
                $clase = 'lineasPares';
            } else {
                $clase = 'lineasImpares';
            }

            $salida = '<div class="row mb-3 ' . $clase . ' lineaFact lineas" id="lineaFacturaNueva_' . $order . '">'
                .    '<div class="form-group row col-md-12 mb-0">'
                .       '<div class="col-md-1 col-sm-2">'
                .           '<label class="labelCampoPres">Cantidad</label>'
                .           '<input id="cantidadNueva' . $order . '" data-nueva="1" data-fila="' . $order . '" value="' . $datos["cantidad"] . '" type="number" step="0.001" class="text-right form-control lineaCoste cantidad inputRecalculo px-0" name="importeFactura" required>'
                .       '</div>'
                .       '<div class="col-md-1 col-sm-2">'
                .           '<label class="labelCampoPres">Importe</label>'
                .           '<input id="importeFacturaNueva' . $order . '" data-nueva="1" data-fila="' . $order . '" value="' . $datos["importe"] . '" type="number" step="0.001" class="text-right form-control lineaCoste importeFactura inputRecalculo px-0" name="importeFactura" required>'
                .       '</div>'
                .       '<div class="col-md-1 col-sm-2">'
                .           '<label class="labelCampoPres">IVA(%)</label>'
                .           '<input id="ivaNueva' . $order . '" data-nueva="1" data-fila="' . $order . '" value="' . $datos['iva'] . '" type="number" step="0.001" class="text-right form-control lineaCoste iva inputRecalculo px-0" name="iva" required>'
                .       '</div>'
                .       '<div class="col-md-1 col-sm-2">'
                .           '<label class="labelCampoPres">Total</label>'
                .           '<input id="totalNueva' . $order . '" data-nueva="1" value="' . $datos["totalIngreso"] . '" type="number" step="0.001" class="text-right form-control lineaCoste total px-0" name="total" required readonly>'
                .       '</div>'
                .       '<div class="col-md-2 col-sm-2">'
                .           '<label class="labelCampoPres">Fecha</label>'
                .           '<input id="fechaFacturaNueva' . $order . '" value="' . $datos["fecha"] . '" type="date" class="form-control lineaCoste" name="fechaFactura" required>'
                .       '</div>';
            $salida .=      '<div class="col-md-3 col-sm-2">'
                .           '<label class="labelCampoPres">IBAN</label>'
                .           '<select id="ibanNueva' . $order . '" type="text" class="form-control lineaCoste todos" name="iban">'
                .               '<option disabled selected>Seleccionar</option>';
            foreach ($ctasBancarias as $cuenta) {
                $salida .= '<option value="' . $cuenta->idcuenta . '">' . $cuenta->iban . '</option>';
            }
            $salida .=          '</select>'
                .       '</div>'
                .       '<div class="col-md-1 col-sm-2">'
                .           '<label class="labelCampoPres">Nº Factura</label>'
                .           '<input id="numFacturaNueva' . $order . '" type="text" class="form-control lineaCoste" name="numFactura" style="width: 100%;" readonly>'
                .       '</div>'
                .       '<div class="col-md-2 col-sm-2">'
                .           '<label class="labelCampoPres">Fecha Cobro</label>'
                .           '<input id="fechaCobroNueva' . $order . '" value="' . $datos["fechaCobro"] . '" type="date" class="form-control lineaCoste" name="fechaCobro">'
                .       '</div>'
                .       '<div class="col-md-3 col-sm-2">'
                .           '<label class="labelCampoPres">Tipo concepto</label>'
                .           '<select id="tipoConceptoNueva' . $order . '" data-nueva="1" type="text" class="form-control lineaCoste todos tipoConcepto" data-indice="' . $order . '">'
                .               '<option disabled selected>Seleccionar</option>'
                .               '<option value="1">Formación - Organizador</option>'
                .               '<option value="2">Formación - Autogestión</option>'
                .               '<option value="3">Gestión Formación</option>'
                .               '<option value="4">Gestión Consultoría</option>'
                .               '<option value="5">Gestión Selección</option>'
                .          '</select>'
                .       '</div>'
                .       '<div class="col-md-3 col-sm-2">'
                .           '<label class="labelCampoPres">Concepto</label>'
                .           '<div>'
                .               '<a class="btn btn-secondary text-white crearConcepto" id="crearConceptoNueva' . $order . '" data-indice="' . $order . '">Editar concepto <i class="fas fa-chevron-down" style="color:white;"></i></a>'
                .           '</div>'
                .       '</div>'
                .       '<div class="col-md-2 col-sm-2">'
                .           '<label class="labelCampoPres">Tipo Folio</label>'
                .             '<select id="tipoFolioNueva' . $order . '" type="text" class="form-control " data-fila="' . $order . '" data-nueva="1" name="tipoFolio">'
                .                   '<option value="folio1">Folio1</option>'
                .                   '<option value="folio2">Folio2</option>'
                .                   '<option value="folio3">Folio3</option>'
                .               '</select>'
                .       '</div>'
                .       '<div class="col-md-2 col-sm-2" style="display:none;">'
                .           '<label class="labelCampoPres">Predefinido</label>'
                .           '<div class="d-lg-flex mb-1">'
                .               '<input class="form-check-input conceptoPredefinido" type="checkbox" data-idaccion="' . $order . '"'
                .                   'id="checkPredefinidoNueva' . $order . '" name="checkAccionNuevo[]" value="0">'
                .           '</div>'
                .       '</div>'
                .       '<div class="col-md-2 col-sm-2">'
                .           '<label class="labelCampoPres">Acciones</label>'
                .           '<div class="d-lg-flex mb-1">'
                .               '<input class="form-check-input marcaraccion" type="checkbox" data-idaccion="' . $order . '"'
                .                   'id="checkAccionNueva' . $order . '" name="checkAccionNuevo[]" value="' . $order . '">'
                .                '<a id="btnFacturarFila' . $order . '" data-indice="' . $order . '" class="btn btn-success mr-1 btnFacturarFila" name="btnFacturarFila" title="Emitir factura" style="float:right"><i class="fas fa-thumbs-up" style="color:white;float:right;"></i></a>'
                .                '<a id="btnEliminarFila' . $order . '" class="btn btn-danger mr-1 btnEliminarFila" name="btnEliminarFila" data-indice="' . $order . '" title="Eliminar" style="float:right"><i class="fas fa-trash-alt" style="color:white;float:right;"></i></a>'
                .           '</div>'
                .       '</div>'
                .       '<div class="col-md-12 col-sm-12 mt-2 mb-4" id="contEditorConceptoNueva' . $order . '" style="display:none;">'
                .           '<textarea id="editorNueva' . $order . '" name="editor' . $order . '" rows="1" cols="10" class="form-control">' . $datos["concepto"] . '</textarea><br>'
                .       '</div>';

            $salida .= '</div>';
        }
        echo $salida;
    }


    public function agregarLineaGasto()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $total = $_POST['total'];
            $idAccionProy = $_POST['idAccionProy'];
        }

        $resultado = $this->agregarLineaGastoHTML($total, $idAccionProy);

        echo json_encode($resultado);
    }

    public function agregarLineaGastoHTML($total, $idAccionProy)
    {

        $order = (int)$total + 1;

        $tipoGastos = $this->ModelProyecto->obtenerTipoGastosGenerales();

        $ctasBancarias = $this->ModelProyecto->obtenerCuentasBancarias();

        if ($order % 2 != 0) {
            $clase = 'lineasPares';
        } else {
            $clase = 'lineasImpares';
        }

        $datos = [];

        $salida = '<div class="row ' . $clase . ' lineasGasto" id="lineaGastoNueva_' . $order . '">'
            .    '<div class="form-group row col-md-12 mb-0">'
            .       '<div class="col-md-2 col-sm-2">'
            .           '<label class="labelCampoPres">Tipo gasto</label>'
            . '<select id="gastoNueva' . $order . '" type="text" class="form-control lineaGasto tipoGasto  todos" name="gasto" size="4">'
            . '<option>Seleccionar</option>';
        foreach ($tipoGastos as $gastos) {
            $salida .= '<option value="' . $gastos->idgasto . '">' . $gastos->descripcion . '</option>';
        }
        $salida .=  '</select>'
            .       '</div>'
            .       '<div class="col-md-2 col-sm-2">'
            .           '<label class="labelCampoPres">Tipo Proveedor</label>'
            .             '<select id="proveedorNueva' . $order . '" type="text" class="form-control lineaGasto tipoProveedor" data-fila="' . $order . '" data-nueva="1" name="proveedor">'
            . '<option>Seleccionar</option>'
            . '<option value="proveedor">Proveedor</option>'
            . '<option value="profesor">Profesor</option>'
            . '<option value="colaborador">Colaborador</option>'
            .   '</select>'
            .       '</div>'
            .       ' <div class="col-md-3 col-sm-2">'
            .           '<label class="labelCampoPres">Razón Social</label>'
            .       '<select id="razonSocialNueva' . $order . '" type="text" data-fila="' . $order . '" class="form-control lineaGasto  razonSocial" name="razon">'
            .       '<option>Seleccionar</option>'
            .       '</select>'
            .    '</div>'
            .       '<div class="col-md-1 col-sm-2">'
            .           '<label class="labelCampoPres">Importe</label>'
            .           '<input id="importeGastoNueva' . $order . '" data-nueva="1" type="number" data-fila="' . $order . '" class="text-right form-control lineaGasto importeGasto total" name="importeGasto" required>'
            .       '</div>'
            .       '<div class="col-md-1 col-sm-2">'
            .           '<label class="labelCampoPres">Cantidad</label>'
            .           '<input id="cantidadGastoNueva' . $order . '" data-nueva="1" type="number" data-fila="' . $order . '" class="form-control cantidadGasto lineaGasto" name="fechaFactura" required>'
            .       '</div>'
            .     ' <div class="col-md-1 col-sm-2">'
            .           '<label class="labelCampoPres">IVA</label>'
            .           '<input id="ivaGastoNueva' . $order . '" data-nueva="1" type="number" data-fila="' . $order . '" class="form-control ivaGasto lineaGasto"  name="numFactura" style="width: 100%;" >'
            .       '</div>'
            .       '<div class="col-md-1 col-sm-2">'
            .           '<label class="labelCampoPres">IRPF</label>'
            .               ' <input id="irpfNueva' . $order . '" data-nueva="1" type="number" data-fila="' . $order . '" class="form-control irpf  lineaGasto" name="numFactura" style="width: 100%;" >'
            .               '</div>'
            . ' <div class="col-md-1 col-sm-2">'
            . '<label class="labelCampoPres">Total</label>'
            . '<input id="totalGastoNueva' . $order . '" data-nueva="1" data-fila="' . $order . '" type="number" class="form-control lineaGasto" name="fechaCobro" readonly>'
            . ' </div>'
            . '<div class="col-md-2 col-sm-2">'
            . ' <label class="labelCampoPres">Num. Factura</label>'
            . '<input id="numFacturaNueva' . $order . '" type="text" class="form-control lineaGasto" name="numFactura" style="width: 100%;">'
            . '</div>'
            . '<div class="col-md-2 col-sm-2">'
            . '<label class="labelCampoPres">Fecha Factura</label>'
            . '<input id="fechaFacturaNueva' . $order . '" type="date" class="form-control lineaGasto" name="fechaCobro">'
            . '</div>';
        $salida .=      '<div class="col-md-3 col-sm-2">'
            .           '<label class="labelCampoPres">IBAN</label>'
            .           '<select id="ibanGastoNueva' . $order . '" type="text" class="form-control lineaCoste todos" name="iban">'
            .               '<option disabled selected>Seleccionar</option>';
        foreach ($ctasBancarias as $cuenta) {
            $salida .= '<option value="' . $cuenta->idcuenta . '">' . $cuenta->iban . '</option>';
        }
        $salida .=  '</select>'
            .  '</div>'
            . '<div class="col-md-2 col-sm-2">'
            . '<label class="labelCampoPres">Concepto</label>'
            . '<textarea id="editorNueva' . $order . '" name="editor' . $order . '" rows="1" cols="10" class="form-control"></textarea><br>'
            . '</div>'
            . '<div class="col-md-2 col-sm-2">'
            . '<label class="labelCampoPres">Fecha Pago</label>'
            . '<input id="fechaCobroNueva' . $order . '" type="date" class="form-control lineaGasto" name="fechaCobro">'
            . '</div>'
            . '<div class="col-md-1 col-sm-2">'
            . '<label class="labelCampoPres">Acciones</label>'
            . '<div class="d-lg-flex mb-1">'
            // . '<input class="form-check-input marcaraccion" type="checkbox" data-idaccion="' . $order . '" id="checkAccionGastos' . $order . '" name="checkAccionGastoNuevo[]" value="' . $order . '">'
            . '<a id="btnGuardarGasto' . $order . '" data-indice="' . $order . '" class="btn btn-primary mr-1 btnGuardarGasto" name="btnGuardarGasto" title="Guardar Gasto" style="float:right"><i class="fas fa-save" style="color:white;float:right;"></i></a>'
            . '<a id="btnEliminarFilaGastos' . $order . '" class="btn btn-danger mr-1 btnEliminarFila" data-indice="' . $order . '" data-gastos="1" name="btnFacturarFila" title="Eliminar" style="float:right"><i class="fas fa-trash-alt" style="color:white;float:right;"></i></a>'
            . '</div>'
            . '</div>'
            . '</div>';


        $datos = [
            "html" => $salida,
            "contador" => $order
        ];

        return $datos;
    }

    public function agregarLineaGastoComun()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $total = $_POST['total'];
            $idAccionProy = $_POST['idAccionProy'];
            $idProyecto =  $_POST['idProyecto'];
        }

        $resultado = $this->agregarLineaGastoComunHTML($total, $idAccionProy, $idProyecto);

        echo json_encode($resultado);
    }

    public function agregarLineaGastoComunHTML($total, $idAccionProy, $id)
    {
        $ficha = $this->ModelProyecto->fichaProyecto($id);

        $order = (int)$total + 1;

        $tipoGastos = $this->ModelProyecto->obtenerTipoGastosGenerales();

        if ($order % 2 != 0) {
            $clase = 'lineasPares';
        } else {
            $clase = 'lineasImpares';
        }

        $contador = 0;

        $datos = [];

        $salida = '<div class="row ' . $clase . ' lineasGastoComun" id="lineaGastoComunNueva_' . $order . '">'
            .    '<div class="form-group row col-md-12 mb-0">'
            .       '<div class="col-md-2 col-sm-2">'
            .           '<label class="labelCampoPres">Tipo gasto</label>'
            . '<select id="gastoComunNueva' . $order . '" type="text" class="form-control lineaGasto tipoGasto  todos" name="gasto" size="4">'
            . '<option>Seleccionar</option>';
        foreach ($tipoGastos as $gastos) {
            $salida .= '<option value="' . $gastos->idgasto . '">' . $gastos->descripcion . '</option>';
        }
        $salida .=  '</select>'
            .       '</div>'
            .       '<div class="col-md-2 col-sm-2">'
            .           '<label class="labelCampoPres">Tipo Proveedor</label>'
            .             '<select id="proveedorComunNueva' . $order . '" type="text" class="form-control lineaGasto tipoProveedor" data-fila="' . $order . '" data-nueva="1" data-comun="1" name="proveedor">'
            . '<option>Seleccionar</option>'
            . '<option value="proveedor">Proveedor</option>'
            . '<option value="profesor">Profesor</option>'
            . '<option value="colaborador">Colaborador</option>'
            .   '</select>'
            .       '</div>'
            .       ' <div class="col-md-3 col-sm-2">'
            .           '<label class="labelCampoPres">Razón Social</label>'
            .       '<select id="razonSocialComunNueva' . $order . '" type="text" data-fila="' . $order . '" class="form-control lineaGasto  razonSocial" name="razon">'
            .       '<option>Seleccionar</option>'
            .       '</select>'
            .    '</div>'
            .       '<div class="col-md-1 col-sm-2">'
            .           '<label class="labelCampoPres">Importe</label>'
            .           '<input id="importeGastoComunNueva' . $order . '" data-nueva="1" data-comun="1" type="number" data-fila="' . $order . '" class="text-right form-control lineaGasto importeGasto total" name="importeGasto" required>'
            .       '</div>'
            .       '<div class="col-md-1 col-sm-2">'
            .           '<label class="labelCampoPres">Cantidad</label>'
            .           '<input id="cantidadGastoComunNueva' . $order . '" data-nueva="1" data-comun="1" type="number" data-fila="' . $order . '" class="form-control cantidadGasto lineaGasto" name="fechaFactura" required>'
            .       '</div>'
            .     ' <div class="col-md-1 col-sm-2">'
            .           '<label class="labelCampoPres">IVA</label>'
            .           '<input id="ivaGastoComunNueva' . $order . '" data-nueva="1" data-comun="1" type="number" data-fila="' . $order . '" class="form-control ivaGasto lineaGasto"  name="numFactura" style="width: 100%;" >'
            .       '</div>'
            .       '<div class="col-md-1 col-sm-2">'
            .           '<label class="labelCampoPres">IRPF</label>'
            .               ' <input id="irpfComunNueva' . $order . '" data-nueva="1" data-comun="1" type="number" data-fila="' . $order . '" class="form-control irpf  lineaGasto" name="numFactura" style="width: 100%;" >'
            .               '</div>'
            . ' <div class="col-md-1 col-sm-2">'
            . '<label class="labelCampoPres">Total</label>'
            . '<input id="totalGastoComunNueva' . $order . '" data-nueva="1" data-comun="1" data-fila="' . $order . '" type="number" class="form-control lineaGasto" name="fechaCobro" readonly>'
            . ' </div>'
            . '<div class="col-md-2 col-sm-2">'
            . ' <label class="labelCampoPres">Num. Factura</label>'
            . '<input id="numFacturaComunNueva' . $order . '" type="text" class="form-control lineaGasto" name="numFactura" style="width: 100%;">'
            . '</div>'
            . '<div class="col-md-2 col-sm-2">'
            . '<label class="labelCampoPres">Fecha Factura</label>'
            . '<input id="fechaFacturaComunNueva' . $order . '" type="date" class="form-control lineaGasto" name="fechaCobro">'
            . '</div>'
            . '<div class="col-md-3 col-sm-2">'
            . '<label class="labelCampoPres">Concepto</label>'
            . '<textarea id="editorComunNueva' . $order . '" name="editor' . $order . '" rows="1" cols="10" class="form-control"></textarea><br>'
            . '</div>'
            . '<div class="col-md-2 col-sm-2">'
            . '<label class="labelCampoPres">Fecha Pago</label>'
            . '<input id="fechaCobroComunNueva' . $order . '" type="date" class="form-control lineaGasto" name="fechaCobro">'
            . '</div>'
            . '<div class="col-md-2 col-sm-2">'
            . '<label class="labelCampoPres">Acciones</label>'
            . '<div class="d-lg-flex mb-1">'
            . '<input class="form-check-input marcaraccion" type="checkbox" data-idaccion="' . $order . '" id="checkAccionGastos' . $order . '" name="checkAccionGastoNuevo[]" value="' . $order . '">'
            . '<a id="btnGuardarGastoComun' . $order . '" data-indice="' . $order . '" class="btn btn-primary mr-1 btnGuardarGastoComun" name="btnGuardarGasto" title="Guardar Gasto" style="float:right"><i class="fas fa-save" style="color:white;float:right;"></i></a>'
            . '<a id="btnEliminarFilaGastosComun' . $order . '" class="btn btn-danger mr-1 btnEliminarFila" data-indice="' . $order . '" data-gastosComun="1" name="btnFacturarFila" title="Eliminar" style="float:right"><i class="fas fa-trash-alt" style="color:white;float:right;"></i></a>'
            . '</div>'
            . '</div>'
            .       '<div class="col-md-1 col-sm-2">'
            .           '<label class="labelCampoPres">Concepto</label>'
            .           '<div>'
            .               '<a class="btn btn-secondary text-white repartirGastos" id="repartirGastosNueva' . $order . '" data-indice="' . $order . '">Repartir Gastos <i class="fas fa-chevron-down" style="color:white;"></i></a>'
            .           '</div>'
            .       '</div>'
            .       '<div class="col-md-12 col-sm-12 mt-2 mb-4 row" id="contRepartirGastos' . $order . '" style="display:none;">'
            . '<form id="addClientesGastos' . $order . '" method="POST">';
        foreach ($ficha['clientes'] as $cliente) {
            $salida .=  '<div class="col-md-12 col-sm-12 mt-2 mb-4 row" name="datosClientes">'
                . '<div class="col-md-6">'
                .  '<label class="labelCampoPres">Clientes</label>'
                . '<input id="cliente' . $contador . '" name="cliente' . $contador . '"  class="form-control mb-2" value="' . $cliente->NOMBREJURIDICO . '" readonly />'
                . '</div>'
                . '<div class="col-md-2">'
                .   '<label class="labelCampoPres">Importe</label>'
                . '<input type="number" data-posicion="' . $order . '" name="importe' . $contador . '" data-fila="' . $contador . '" id="importeCliente' . $contador . '"  class="form-control importeClienteNueva mb-2" value=""/>'
                . '</div>'
                . '<div class="col-md-4">'
                .     '<label class="labelCampoPres">Fecha Cobro Cliente</label>'
                .     '<input type="date" data-posicion="' . $order . '" name="fechacobro' . $contador . '" data-fila="' . $contador . '" id="fechaCliente' . $contador . '"  class="form-control fechaCliente mb-2" value=""/>'
                .     '<input type="hidden"  name="idEmpresa' . $contador . '"  value="' . $cliente->idEMPRESA . '"/>'
                .     '<input type="hidden"  name="contadorFilasClientes"  value="' . $contador . '"/>'
                . '</div>'
                . '</div>';
            $contador++;
        }
        $salida .= '</form>'
            . '<div class="col-md-1 col-sm-2">'
            . '<label class="labelCampoPres">Importe Restante</label>'
            . '<input type="number" id="importeRestante' . $order . '"  class="form-control" name="importeRestante" readonly >'
            . '</div>'
            . '</div>'
            . '</div>'
            . '</div>';



        $datos = [
            "html" => $salida,
            "contador" => $order
        ];

        return $datos;
    }



    public function editarFactura()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datosPost = $_POST;
        }

        $datos = [
            "idfactura" => $datosPost['idfactura'],
            "tabla" => $datosPost['tabla'],
            "campo" => $datosPost['campo'],
            "valor" => $datosPost['valor'],
            "pk" => $datosPost['pk']
        ];

        $this->ModelProyecto->actualizarDatosFactura($datos);
    }

    public function actualizarConcepto()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $datosPost = $_POST;
        }

        $datos = [
            "idFactura" => $datosPost['idFactura'],
            "concepto" => $datosPost['concepto']
        ];

        $this->ModelProyecto->actualizarConceptoFactura($datos);
    }

    public function obtenerTipoConceptoFacturaIngreso()
    {
        if ($_POST['tipoConcepto'] && $_POST['idAccionProy'] && $idAccionPres = $_POST['idAccionPres']) {

            $tipoConcepto = $_POST['tipoConcepto'];
            $idAccionProy = $_POST['idAccionProy'];
            //$idAccionPres = $_POST['idAccionPres'];

            //traigo los datos que irán en el concepto:
            $campos = $this->ModelProyecto->datosDeAccionProyectoPorId($idAccionProy);
            $datos = [
                'horas' => $campos->horas,
                'accion' => $campos->idACCION,
                'grupo' => $campos->idProyecto,
                'denominacion' => $campos->NOMBREACCION,
                'fechaInicio' => $campos->fechaInicio,
                'fechaFin' => $campos->fechaFin,
                'participantes' => $campos->participantes
            ];

            switch ($tipoConcepto) {
                case 1:
                    $metodo = 'construirConceptoFormacionOrganizador';
                    break;
                case 2:
                    $metodo = 'construirConceptoFormacionAutogestion';
                    break;
                case 3:
                    $metodo = 'construirConceptoFormacion';
                    break;
                case 4:
                    $metodo = 'construirConceptoConsultoria';
                    break;
                case 5:
                    $metodo = 'construirConceptoSeleccion';
                    break;
                default:
            }
            $htmlConcepto = $this->$metodo($datos);

            echo $htmlConcepto;
        }
    }



    public function construirConceptoFormacionOrganizador($datos)
    {
        $salida = '<p><b><u>SERVICIOS DE FORMACIÓN:&nbsp; según los siguientes datos:</u></b></p>
                   <br>
                   <p style="margin-bottom: 0rem;"><b>DURACIÓN</b>: ' . $datos['horas'] . ' Horas</p>
                   <p style="margin-bottom: 0rem;"><b>ACCIÓN NÚMERO</b>: ' . $datos['accion'] . ' &nbsp; <b>GRUPO: </b>' . $datos['grupo'] . '</p>
                   <p style="margin-bottom: 0rem;"><b>DENOMINACIÓN CURSO :</b>&nbsp; &nbsp;' . $datos['denominacion'] . '</p>
                   <p style="margin-bottom: 0rem;"><b>FECHA DE INICIO:&nbsp; &nbsp;</b>' . $datos['fechaInicio'] . '</p>
                   <p style="margin-bottom: 0rem;"><b>FECHA DE FINAL:</b>&nbsp; &nbsp;' . $datos['fechaFin'] . '</p>
                   <br>
                   <p style="margin-bottom: 0rem;"><b>COSTE DIRECTO:</b>&nbsp; &nbsp;[RELLENAR COSTE]</p>
                   <p style="margin-bottom: 0rem;"><b>COSTE GESTION:</b>&nbsp; &nbsp;[RELLENAR COSTE]</p>

                   <p><b>Número de Alumnos:</b>&nbsp; &nbsp; ' . $datos['participantes'] . '</p>';

        return $salida;
    }
    public function construirConceptoFormacionAutogestion($datos)
    {
        $salida = '<p><b><u>SERVICIOS DE FORMACIÓN:&nbsp; Gestión de la bonificación por formación, según los siguientes datos:</u></b></p>
                   <br>
                   <p style="margin-bottom: 0rem;"><b>DURACIÓN</b>: ' . $datos['horas'] . ' Horas</p>
                   <p style="margin-bottom: 0rem;"><b>ACCIÓN NÚMERO</b>: ' . $datos['accion'] . ' &nbsp; <b>GRUPO: </b>' . $datos['grupo'] . '</p>
                   <p style="margin-bottom: 0rem;"><b>DENOMINACIÓN CURSO :</b>&nbsp; &nbsp;' . $datos['denominacion'] . '</p>
                   <p style="margin-bottom: 0rem;"><b>FECHA DE INICIO:&nbsp; &nbsp;</b>' . $datos['fechaInicio'] . '</p>
                   <p style="margin-bottom: 0rem;"><b>FECHA DE FINAL:</b>&nbsp; &nbsp;' . $datos['fechaFin'] . '</p>
                   <br>
                   <p><b>Número de Alumnos:</b>&nbsp; &nbsp; ' . $datos['participantes'] . '</p>';

        return $salida;
    }
    public function construirConceptoFormacion($datos)
    {
        $salida = '<p><b><u>SERVICIOS DE FORMACIÓN:&nbsp; según los siguientes datos:</u></b></p>
                   <br>
                   <p style="margin-bottom: 0rem;"><b>DURACIÓN</b>: ' . $datos['horas'] . ' Horas</p>
                   <p style="margin-bottom: 0rem;"><b>ACCIÓN NÚMERO</b>: ' . $datos['accion'] . ' &nbsp; <b>GRUPO: </b>' . $datos['grupo'] . '</p>
                   <p style="margin-bottom: 0rem;"><b>DENOMINACIÓN CURSO :</b>&nbsp; &nbsp;' . $datos['denominacion'] . '</p>
                   <p style="margin-bottom: 0rem;"><b>FECHA DE INICIO:&nbsp; &nbsp;</b>' . $datos['fechaInicio'] . '</p>
                   <p style="margin-bottom: 0rem;"><b>FECHA DE FINAL:</b>&nbsp; &nbsp;' . $datos['fechaFin'] . '</p>
                   <br>
                   <p><b>Número de Alumnos:</b>&nbsp; &nbsp; ' . $datos['participantes'] . '</p>';

        return $salida;
    }

    public function construirConceptoConsultoria($datos)
    {
        $salida = '<p><b><u>SERVICIOS DE CONSULTORIA:&nbsp; según los siguientes datos:</u></b></p>
                   <br>
                   <p style="margin-bottom: 0rem;">[INSERTE PORCENTAJE]<b> DE LA SELECCIÓN PARA</b> [INSERTE NUMERO ALUMNOS] <b> ALUMNO/S EN PRÁCTICAS</b></p>
                   <p style="margin-bottom: 0rem;"><b>EXTRACURRICULARES DPTO. ADMINISTRACIÓN (SOPORTE VENTAS)</b></p>';

        return $salida;
    }

    public function construirConceptoSeleccion($datos)
    {
        $salida = '<p><b><u>SERVICIOS DE SELECCIÓN:&nbsp; según los siguientes datos:</u></b></p>
                   <br>
                   <p style="margin-bottom: 0rem;">[INSERTE PORCENTAJE]<b> DE LA SELECCIÓN PARA</b> [INSERTE NUMERO ALUMNOS] <b> ALUMNO/S EN PRÁCTICAS</b></p>
                   <p style="margin-bottom: 0rem;"><b>EXTRACURRICULARES DPTO. ADMINISTRACIÓN (SOPORTE VENTAS)</b></p>';

        return $salida;
    }

    public function cargarContactos()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $numfactura = $_POST['numFactura'];
        }

        $contactos = $this->ModelProyecto->cargarContactos($numfactura);

        $salida = '<select class="form-control lineaCoste  mailClienteEnviar" id="mail" name="mail">'
            . '<option>Seleccionar</option>';
        foreach ($contactos as $contacto) {
            $salida .= '<option value="' . $contacto->idContacto . '" >' . $contacto->datos . '</option>';
        }
        $salida .=  '</select>';

        echo $salida;
    }

    public function cargarFirmaEditorEmail()
    {
        session_start();
        $salida = '<p> Buenos dias! <br> Le adjuntamos la factura correspondiente por los servicios brindados. Por favor no responda a este correo.</p>
                <br><br>                
                <p style="color:#2ba5dc;font-size: 1.4rem;margin-bottom:0.9rem;text-align:left;"><b>' . $_SESSION['nombre'] . '</b></p>
                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 1rem;text-align:left; height: 1.3rem;">' . $_SESSION['puesto'] . '</p>
                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 1rem;text-align:left; height: 1.3rem; color:#2ba5dc;">' . $_SESSION['mail'] . '</p>
                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 1rem;text-align:left; height: 1.3rem;">' . $_SESSION['telefono'] . '</p>';

        echo $salida;
    }

    public function cargarEmpleados()
    {
        $resultado = $this->ModelProyecto->cargarEmpleados();

        echo json_encode($resultado);
    }

    public function eliminarGasto()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idgasto = $_POST['idgasto'];
        }

        $this->ModelProyecto->eliminarGasto($idgasto);
        $this->ModelProyecto->eliminarGastoCliente($idgasto);
    }

    public function obtenerDatosEmailFactura()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idEmail = $_POST['idEmail'];
        }

        $resultado = $this->ModelProyecto->obtenerDatosEmailFactura($idEmail);

        echo json_encode($resultado);
    }

    public function obtenerDatosSelects()
    {

        $nivelEstudios = $this->ModelProyecto->obtenerNivelEstudios();
        $categoriaProfesional = $this->ModelProyecto->obtenerCategoriaProfesional();
        $grupoCotizacion = $this->ModelProyecto->obtenerGruposCotizacion();

        $datos = [
            "Estudios" => $nivelEstudios,
            "Categoria" => $categoriaProfesional,
            "Grupo" => $grupoCotizacion
        ];

        echo json_encode($datos);
    }

    
    public function obtenerDatosSelectsEditar()
    {

        $nivelEstudios = $this->ModelProyecto->obtenerNivelEstudios();
        $categoriaProfesional = $this->ModelProyecto->obtenerCategoriaProfesional();
        $grupoCotizacion = $this->ModelProyecto->obtenerGruposCotizacion();

        $datos = [
            "Estudios" => $nivelEstudios,
            "Categoria" => $categoriaProfesional,
            "Grupo" => $grupoCotizacion
        ];

        return $datos;
    }

    public function obtenerDatosParticipante()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $idParticipante = $_POST['idParticipante'];

            $datos = $this->ModelProyecto->obtenerDatosParticipante($idParticipante);
            $datosSelect = $this->obtenerDatosSelectsEditar();

            $resultado = [
                "datosParticipante" => $datos,
                "datosSelect" => $datosSelect 
            ];

            echo json_encode($resultado);
        }
    }
}
