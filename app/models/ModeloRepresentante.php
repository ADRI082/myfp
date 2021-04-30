<?php


class ModeloRepresentante{
 private $db;

public function __construct(){
    $this->db = new Base;
}
public function obtenerClientes()
{
    $this->db->query('SELECT idEMPRESA as id, NOMBREJURIDICO  FROM empresasclientes');
    $resultado = $this->db->registros();
    return $resultado;
} 
public function obtenerRepresentante(){

       
    $table = "(select idRepresentante, NOMBREJURIDICO, representante.NOMBREREPRESENTANTE, representante.NIFREPRESENTANTE, representante.telefono, 
    representante.movil, representante.email from representante
    LEFT JOIN empresasclientes on empresasclientes.idEMPRESA = representante.idEMPRESA
       ) temp";

        // $table = "empresasclientes";

        //  echo $table;
    // Table's primary key
    $primaryKey = 'idRepresentante';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database, while the `dt`
    // parameter represents the DataTables column identifier. In this case simple
    // indexes
    $columns = array(
        array( 'db' => 'idRepresentante', 'dt' => 'DT_RowId' ),
        array( 'db' => 'NOMBREJURIDICO',  'dt' => 0 ),
        array( 'db' => 'NOMBREREPRESENTANTE',  'dt' => 1 ),
        array( 'db' => 'NIFREPRESENTANTE',  'dt' => 2 ),
        array( 'db' => 'telefono',  'dt' => 3 ),  
        array( 'db' => 'movil',  'dt' => 4),
        array( 'db' => 'email',  'dt' => 5)

    
    );

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP
     * server-side, there is no need to edit below this line.
     */


    require( 'ssp.class.php' );
    echo json_encode(
        SSP::simple( $_GET, $table, $primaryKey, $columns )
    );


}
// AÑADIR REPRESENTANTE
public function agregarRepresentante($datos)
{

    $this->db->query("INSERT INTO  representante (idEMPRESA, NOMBREREPRESENTANTE, NIFREPRESENTANTE,
    telefono, movil, email) values ( :idEMPRESA, :NOMBREREPRESENTANTE, :NIFREPRESENTANTE,
    :telefono, :movil, :email)");

    // vincular valores
    $this->db->bind(':idEMPRESA', $datos['idEMPRESA']);
    $this->db->bind(':NOMBREREPRESENTANTE', $datos['nombre']);
    $this->db->bind(':NIFREPRESENTANTE', $datos['nif']);
    $this->db->bind(':telefono', $datos['telefono']);
    $this->db->bind(':movil', $datos['movil']);
    $this->db->bind(':email', $datos['email']);
   
    //Ejecutar
    if($this->db->execute()){
        return true;
    } else {
        return false;
    }

}
// MODIFICAR REPRESENTANTE
public function editarRepresentante($datos)
{

    $this->db->query("UPDATE  representante SET idEMPRESA = :idEMPRESA, NOMBREREPRESENTANTE = :NOMBREREPRESENTANTE,
     NIFREPRESENTANTE = :NIFREPRESENTANTE, telefono = :telefono, movil = :movil, email = :email WHERE idRepresentante = :id");

    // vincular valores
    $this->db->bind(':id', $datos['id']);
    $this->db->bind(':idEMPRESA', $datos['idEMPRESA']);
    $this->db->bind(':NOMBREREPRESENTANTE', $datos['nombre']);
    $this->db->bind(':NIFREPRESENTANTE', $datos['nif']);
    $this->db->bind(':telefono', $datos['telefono']);
    $this->db->bind(':movil', $datos['movil']);
    $this->db->bind(':email', $datos['email']);
   
    //Ejecutar
    if($this->db->execute()){
        return true;
    } else {
        return false;
    }

}
// ELIMINAR
public function borrarRepresentante($datos)
{
    
    $this->db->query("Delete from representante where idRepresentante =".$datos['id']);
    
    //Ejecutar
    if($this->db->execute()){
        return true;
    } 
    else {
        echo "error";
        return false;
    }

}

      // SELECT PARA EL MODAL DE EDITAR
      public function getRepresentanteUpdate($id)
      {
       $this->db->query('SELECT * FROM representante WHERE idRepresentante ='.$id);  
       $resultado = $this->db->registros();  
       return $resultado;
      }

}