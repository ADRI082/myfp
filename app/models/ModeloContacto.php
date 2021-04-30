<?php


class ModeloContacto{
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
public function obtenerContacto()
   {

       
    $table = "(select idContacto, NOMBREJURIDICO, nombreC, areaDpto, contactos.direccion, contactos.telefonoFijo, 
    contactos.movil, contactos.mail from contactos
    LEFT JOIN empresasclientes on empresasclientes.idEMPRESA = contactos.idEMPRESA
       ) temp";

        // $table = "empresasclientes";

        //  echo $table;
    // Table's primary key
    $primaryKey = 'idContacto';

    // Array of database columns which should be read and sent back to DataTables.
    // The `db` parameter represents the column name in the database, while the `dt`
    // parameter represents the DataTables column identifier. In this case simple
    // indexes
    $columns = array(
        array( 'db' => 'idContacto', 'dt' => 'DT_RowId' ),
        array( 'db' => 'NOMBREJURIDICO',  'dt' => 0 ),
        array( 'db' => 'nombreC',  'dt' => 1 ),
        array( 'db' => 'areaDpto',  'dt' => 2 ),
        array( 'db' => 'direccion',  'dt' => 3 ),
        array( 'db' => 'telefonoFijo',  'dt' => 4 ),  
        array( 'db' => 'movil',  'dt' => 5),
        array( 'db' => 'mail',  'dt' => 6)

    
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
  // SELECT PARA EL MODAL DE EDITAR
public function getContactoUpdate($id)
  {
   $this->db->query('SELECT * FROM contactos WHERE idContacto ='.$id);  
   $resultado = $this->db->registros();  
   return $resultado;
  }
  // AÑADIR CONTACTO
public function agregarContacto($datos)
{

    $this->db->query("INSERT INTO  contactos (idEMPRESA, nombreC, areaDpto, direccion,
    telefonoFijo, movil, mail) values ( :idEMPRESA, :nombreC, :areaDpto, :direccion,
    :telefonoFijo, :movil, :mail)");

    // vincular valores
    $this->db->bind(':idEMPRESA', $datos['idEMPRESA']);
    $this->db->bind(':nombreC', $datos['nombre']);
    $this->db->bind(':areaDpto', $datos['areaDpto']);
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
// MODIFICAR CONTACTO
public function editarContacto($datos)
{

    $this->db->query("UPDATE  contactos SET idEMPRESA = :idEMPRESA, nombreC = :nombreC, areaDpto = :areaDpto,
     direccion = :direccion, telefonoFijo = :telefonoFijo, movil = :movil, mail = :mail WHERE idContacto = :id");

    // vincular valores
    $this->db->bind(':id', $datos['id']);
    $this->db->bind(':idEMPRESA', $datos['idEMPRESA']);
    $this->db->bind(':nombreC', $datos['nombre']);
    $this->db->bind(':areaDpto', $datos['areaDpto']);
    $this->db->bind(':direccion', $datos['nif']);
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
    public function borrarContacto($datos)
    {
        
        $this->db->query("DELETE FROM contactos WHERE idContacto =".$datos['id']);
        
        //Ejecutar
        if($this->db->execute()){
            return true;
        } 
        else {
            echo "error";
            return false;
        }

    }
}