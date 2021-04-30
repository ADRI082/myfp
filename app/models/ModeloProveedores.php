<?php


class ModeloProveedores{

    private $db;


    public function __construct(){
        $this->db = new Base;
    }
    public function obtenerProveedores()
    {
        $this->db->query('SELECT * FROM proveedores p LEFT JOIN tipoproveedor t ON p.TIPODEPROVEEDOR = t.idTipo
        LEFT JOIN formasdepago f ON p.CODFORMAPAGO = f.CODFORMAPAGO ;');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function listadoMateriales()
    {
        $this->db->query('SELECT m.IDMATERIAL ,m.codproveedor ,m.DESMATERIAL ,m.PRECIOMATERIAL ,m.OBSMATERIAL ,p.NOMBRECOMERCIAL FROM material m LEFT JOIN proveedores p ON m.codproveedor = p.idPROVEEDOR ;');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerDatosProveedores()
    {
        $this->db->query('SELECT * FROM tipoproveedor');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function obtenerPlazosPago()
    {
        $this->db->query('SELECT * FROM formasdepago');
        $resultado = $this->db->registros();
        return $resultado;
    }

    public function insertProveedor($datos)
    {

        $sql = 'INSERT INTO proveedores ('.$datos['campos'].') VALUES ('.$datos['values'].')';
        $this->db->query($sql);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function obtenerDatosProveedorById($idProveedor)
    {

        $this->db->query('SELECT * FROM proveedores where idPROVEEDOR = '.$idProveedor);
        $resultado = $this->db->registro();
        return $resultado;

    }

    public function actualizarDatosProveedor($datos)
    {

        $tabla = $datos['tabla'];
        $campo = $datos['campo'];
        $pk = $datos['pk'];
        $sql = "UPDATE $tabla SET  $campo =  '" . $datos['valor'] . "'  WHERE  $pk = '" . $datos['idProveedor'] . "' ";

        $this->db->query($sql);
        //Ejecutar
        if ($this->db->execute()) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function deleteProveedor($idProveedor)
    {
        $this->db->query("DELETE FROM proveedores where idPROVEEDOR = :id");
        $this->db->bind(':id', $idProveedor);

        if ($this->db->execute()) {
            return 'true';
        } else {
            return 'false';
        }
    }

}