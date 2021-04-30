<?php


class ModeloLeerExcel{

    private $db;

    public function __construct(){
        $this->db = new Base;
    }


    public function insertarDatosBDDesdeExcel($datos){
       
        //valida si los datos existen:
        $this->db->query('SELECT * FROM productos');
        $resultado = $this->db->registros();

        $nuevos = 0;
        $antiguos = 0;
        $arrayNuevos=[];
        $arrayAntiguos=[];

        foreach ($resultado as $row) {
            $this->db->query('SELECT COUNT(*) AS contador FROM productos WHERE codigo='.$row->codigo);
            $resultado = $this->db->registro();
            //si el codigo no existe insertar el código
            if ($resultado->contador == 0) {
                $tmp=['codigo'=>$row->codigo];
                $arrayNuevos[]=$tmp;
                $nuevos++;
            }else if ($resultado->contador >0) { //si existe entonces solo actualizar
                $tmp=['codigo'=>$row->codigo];
                $arrayAntiguos[]=$tmp;
                $antiguos++;
            }
        }
        echo"arrayNuevos:";
        print_r($arrayNuevos);
        echo"<br>contador nuevos:";
        print_r($nuevos);
        echo"<br>arrayAntiguos:";
        print_r($arrayAntiguos);
        echo"<br>contador antiguos:";
        print_r($antiguos);
        /*
        //inserta los datos
        $imported_products = 0;
        foreach ($datos as $key) {
            
            $this->db->query('INSERT INTO productos (codigo, descripcion, precioCompra, precioVenta, existencia)
                            VALUES (:codigoDeBarras,:descripcion,:precioCompra,:precioVenta,:existencia)');
            $this->db->bind(':codigoDeBarras', $key['codigo']);
            $this->db->bind(':descripcion', $key['descripcion']);
            $this->db->bind(':precioCompra', $key['precio']);
            $this->db->bind(':precioVenta', $key['precioVenta']);
            $this->db->bind(':existencia', $key['existencia']);   
            $this->db->execute();
            $imported_products++;
        }
        return $imported_products++;
        */
    }

    public function insertarParticipantesBDDesdeExcel($datos){
       
        /*//valida si los datos existen:
        $this->db->query('SELECT * FROM productos');
        $resultado = $this->db->registros();

        $nuevos = 0;
        $antiguos = 0;
        $arrayNuevos=[];
        $arrayAntiguos=[];

        foreach ($resultado as $row) {
            $this->db->query('SELECT COUNT(*) AS contador FROM productos WHERE codigo='.$row->codigo);
            $resultado = $this->db->registro();
            //si el codigo no existe insertar el código
            if ($resultado->contador == 0) {
                $tmp=['codigo'=>$row->codigo];
                $arrayNuevos[]=$tmp;
                $nuevos++;
            }else if ($resultado->contador >0) { //si existe entonces solo actualizar
                $tmp=['codigo'=>$row->codigo];
                $arrayAntiguos[]=$tmp;
                $antiguos++;
            }
        }
        echo"arrayNuevos:";
        print_r($arrayNuevos);
        echo"<br>contador nuevos:";
        print_r($nuevos);
        echo"<br>arrayAntiguos:";
        print_r($arrayAntiguos);
        echo"<br>contador antiguos:";
        print_r($antiguos);
        */

        
        //inserta los datos
        $participantesImpor = 0;
        foreach ($datos as $key) {
            
            $this->db->query('INSERT INTO empleados (DocIdentidad, Nombre, Apellido1, Apellido2)
                            VALUES (:DocIdentidad,:Nombre,:Apellido1,:Apellido2)');
            $this->db->bind(':DocIdentidad', $key['dni']);
            $this->db->bind(':Nombre', $key['nombre']);
            $this->db->bind(':Apellido1', $key['apellido1']);
            $this->db->bind(':Apellido2', $key['apellido2']);            
            $this->db->execute();

            
            //buscar último insert
            $this->db->query('SELECT idEmpleado FROM empleados  
                            WHERE idEmpleado = (SELECT max(idEmpleado) FROM empleados)');
            $ult = $this->db->registro();
            $ultEmp = $ult->idEmpleado;


            $this->db->query('INSERT INTO participantes (IDPROYECTO, IDEMPLEADO)
                            VALUES (:IDPROYECTO,:IDEMPLEADO)');
            $this->db->bind(':IDPROYECTO', $key['idProyecto']);
            $this->db->bind(':IDEMPLEADO', $ultEmp);
            $this->db->execute();


            $participantesImpor++;
        }

        return $participantesImpor++;
        
    }

}