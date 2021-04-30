<?php

    /**
     * Demostrar lectura de hoja de cálculo o archivo
     * de Excel con PHPSpreadSheet: leer determinada celda
     * por número de columna y fila 
     *
     * @author parzibyte
     */
    # Cargar librerias y cosas necesarias
    //require_once "vendor/autoload.php";
    require_once dirname(__FILE__).'/../../vendor/autoload.php';

    # Indicar que usaremos el IOFactory
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class LeerDocExcel extends Controlador {

        public function __construct() {
            $this->ModelLeerExcel = $this->modelo('ModeloLeerExcel');    
        }

        //funcion de prueba funciona
        /*public function index() {
            $rutaArchivo = DOCUMENTOS_PRIVADOS."Ventas.xlsx";
            
            $documento = IOFactory::load($rutaArchivo);
            //$hojaDeProductos = $documento->getSheet(0);
            $sheet = $documento->getSheet(0);

            $number_products = 0;
            $imported_products = 0;
            $arr_errors=[];
            $arr_data_produts=[];

            foreach ($sheet->getRowIterator(2) as $row) {
                $codigo = trim($sheet->getCellByColumnAndRow(1,$row->getRowIndex()));
                $descripcion = trim($sheet->getCellByColumnAndRow(2,$row->getRowIndex()));
                $precio = trim($sheet->getCellByColumnAndRow(3,$row->getRowIndex()));

                if($codigo == '' || $descripcion=='' || $precio=='')
                continue;

                $data_product=['codigo'=>$codigo,'descripcion'=>$descripcion, 'precio'=>$precio];
                $arr_data_produts[]=$data_product;
                //$number_products++;

            }            

            $imported_products= $this->ModelLeerExcel->insertarDatosBDDesdeExcel($arr_data_produts);
            $data['imported_products']=$imported_products;
            $data['number_products']=$number_products;

            echo"Total de productos: ".$data['imported_products'];
            echo"Total de productos importados: ".$data['imported_products'];
        }*/


        //funcion de prueba funciona
        public function index($idProyecto) {
        
           echo"entra a prueba";
           die;
            $rutaArchivo = DOCUMENTOS_PRIVADOS."plantilla_listado_alumno.xls";
            
            $documento = IOFactory::load($rutaArchivo);
            //$hojaDeProductos = $documento->getSheet(0);
            $sheet = $documento->getSheet(0);

            $numeroParticipantes = 0;
            $particpantesImportados = 0;
            $arr_errors=[];
            $arr_data_produts=[];

            foreach ($sheet->getRowIterator(8) as $row) {
                $dni = trim($sheet->getCellByColumnAndRow(2,$row->getRowIndex()));
                $nombre = trim($sheet->getCellByColumnAndRow(3,$row->getRowIndex()));
                $apellido1 = trim($sheet->getCellByColumnAndRow(4,$row->getRowIndex()));
                $apellido2 = trim($sheet->getCellByColumnAndRow(5,$row->getRowIndex()));

                if($dni == '' || $nombre=='' || $apellido1=='' || $apellido2=='')
                continue;

                $data_product=['dni'=>$dni,'nombre'=>$nombre, 'apellido1'=>$apellido1, 'apellido2'=>$apellido2, 'idProyecto'=>$idProyecto];
                $arr_data_produts[]=$data_product;
                //$numeroParticipantes++;

            }            

            $particpantesImportados= $this->ModelLeerExcel->insertarParticipantesBDDesdeExcel($arr_data_produts);
            $data['particpantesImportados']=$particpantesImportados;
            $data['numeroParticipantes']=$numeroParticipantes;

            echo"Total de Trabajadores: ".$data['particpantesImportados'];
            echo"Total de Trabajadores importados: ".$data['particpantesImportados'];
        }
        
        
    }