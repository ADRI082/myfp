<?php


class ModeloAsesores{
 private $db;

public function __construct()
{
    $this->db = new Base;
}
public function obtenerClientes()
{
    $this->db->query('SELECT idEMPRESA as id, NOMBREJURIDICO  FROM empresasclientes');
    $resultado = $this->db->registros();
    return $resultado;
} 
public function obtenerAsesor(){

       
    $table = "(select idAsesor, NOMBREJURIDICO, asesores.nomasesor, asesores.contacto, asesores.telefonoFijo, 
    asesores.movil, asesores.mail from asesores
    LEFT JOIN empresasclientes on empresasclientes.idEMPRESA = asesores.idEMPRESA
    WHERE asesores.nomasesor IS NOT null
       ) temp";

        // $table = "empresasclientes";

        //  echo $table;
    // Table's primary key
    $primaryKey = 'idAsesor';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database, while the `dt`
    // parameter represents the DataTables column identifier. In this case simple
    // indexes
    $columns = array(
        array( 'db' => 'idAsesor', 'dt' => 'DT_RowId' ),
        array( 'db' => 'idAsesor',  'dt' => 0 ),
        array( 'db' => 'nomasesor',  'dt' => 1),
        array( 'db' => 'contacto',  'dt' => 2 ),
          
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
// AÑADIR ASESOR
public function agregarAsesor($datos)
{

    $this->db->query("INSERT INTO  asesores (idEMPRESA, nomasesor, contacto, direccion,
    telefonoFijo, movil, mail) values ( :idEMPRESA, :nomasesor, :contacto, :direccion,
    :telefonoFijo, :movil, :mail)");

    // vincular valores
    $this->db->bind(':idEMPRESA', $datos['idEMPRESA']);
    $this->db->bind(':nomasesor', $datos['nombre']);
    $this->db->bind(':contacto', $datos['contacto']);
    $this->db->bind(':direccion', $datos['direccion']);
    $this->db->bind(':telefonoFijo', $datos['telefono']);
    $this->db->bind(':movil', $datos['movil']);
    $this->db->bind(':mail', $datos['email']);
   
    //Ejecutar
    if($this->db->execute()){
        return true;
    } else {
        return false;
    }

}
// MODIFICAR ASESOR
public function editarAsesor($datos)
{

    $this->db->query("UPDATE  asesores SET idEMPRESA = :idEMPRESA, nomasesor = :nomasesor, contacto = :contacto,
     direccion = :direccion, telefonoFijo = :telefonoFijo, movil = :movil, mail = :mail WHERE idAsesor = :id");

    // vincular valores
    $this->db->bind(':id', $datos['id']);
    $this->db->bind(':idEMPRESA', $datos['idEMPRESA']);
    $this->db->bind(':nomasesor', $datos['nombre']);
    $this->db->bind(':contacto', $datos['contacto']);
    $this->db->bind(':direccion', $datos['direccion']);
    $this->db->bind(':telefonoFijo', $datos['telefono']);
    $this->db->bind(':movil', $datos['movil']);
    $this->db->bind(':mail', $datos['email']);
   
    //Ejecutar
    if($this->db->execute()){
        return true;
    } else {
        return false;
    }

}
// ELIMINAR
public function borrarAsesor($datos)
{
    
    $this->db->query("Delete from asesores where idAsesor =".$datos['id']);
    
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
   public function getAsesorUpdate($id)
   {
    $this->db->query('SELECT * FROM asesores WHERE idAsesor ='.$id);  
    $resultado = $this->db->registros();  
    return $resultado;
   }
}
