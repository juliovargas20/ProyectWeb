<?php
class OrdenesModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function InsertarDetalle($id_user, $des, $uni, $can, $precio, $sub)
    {
        $sql = "INSERT INTO detalle_ordencompra (`ID_USER`, `DESCRIPCION`, `UNIDADES`, `CANTIDAD`, `PRECIO_U`, `SUB_TOTAL`) VALUES (?,?,?,?,?,?)";
        $datos = array($id_user, $des, $uni, $can, $precio, $sub);
        return $this->save($sql, $datos);
    }

    public function ListarDetalles($id_user)
    {
        $sql = "SELECT * FROM detalle_ordencompra WHERE ID_USER = $id_user";
        return $this->selectAll($sql);
    }
    
    public function CalcularTotal($id_user)
    {
        $sql = "SELECT SUM(SUB_TOTAL) AS TOTAL FROM detalle_ordencompra WHERE ID_USER = $id_user";
        return $this->select($sql);
    }

    public function EliminarDetalle($id)
    {
        $sql = "DELETE FROM detalle_ordencompra WHERE ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }
}

?>