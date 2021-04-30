<?php


class ModeloPlantilla{

    private $db;


    public function __construct()
    {
        $this->db = new Base;
    }
    public function agregarPlantilla($datos){

        $this->db->query("insert into plantillasPres (html,  tipoPlantilla ) values (:html, :tipo)");

        // vincular valores
        $this->db->bind(':html', $datos['html']);
        $this->db->bind(':tipo', $datos['tipo']);
       
        //Ejecutar
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }

    }

    public function obtenerPlantillas()
    {       
        $this->db->query('SELECT * FROM plantillasPres');
        $resultado = $this->db->registros();
        //return $resultado;
        print json_encode($resultado, JSON_UNESCAPED_UNICODE);

        /*$table = "(SELECT * FROM plantillasPres) temp";
        $primaryKey = 'idPlantilla';
        $columns = array(
          array( 'db' => 'idPlantilla', 'dt' => 0 ),
          array( 'db' => 'tipoPlantilla',  'dt' => 1 ),          
          array( 'db' => 'version', 'dt' => 2 ),
          array( 'db' => 'fechaCreacion',  'dt' => 3 ),          
        );

        require( 'ssp.class.php' );
        echo json_encode(
            SSP::simple( $_GET, $table, $primaryKey, $columns )
        );*/
    }

    public function borrarPlantillas($idPlantilla)
    {
        $this->db->query("DELETE FROM plantillasPres where idPlantilla =".$idPlantilla);
        $this->db->execute();


        /*if($this->db->execute()){
            return true;
        } 
        else {
            echo "error";
            return false;
        }*/
    }
    
}