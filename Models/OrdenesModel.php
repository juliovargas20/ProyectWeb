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

    public function EliminarTodosDetalles($id)
    {
        $sql = "DELETE FROM detalle_ordencompra WHERE ID_USER = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function RegistrarOrdenCompra($area, $nece, $concep, $moneda, $total, $blob)
    {
        $sql = "INSERT INTO ordencompra (`AREA`, `NECESIDAD`, `CONCEPTO`, `MONEDA`, `TOTAL`, `PDF`) VALUES (?,?,?,?,?,?)";
        $sql2 = "SELECT MAX(ID) FROM ordencompra";
        $datos = array($area, $nece, $concep, $moneda, $total, $blob);
        return $this->getIDString($sql, $datos, $sql2);
    }

    public function MaxAu1()
    {
        $sql = "SELECT CONCAT('OC', LPAD(IFNULL(MAX(CONVERT(SUBSTRING(ID, 3), SIGNED INTEGER)), 0) + 1, 6, '0')) AS nuevo_numero FROM OrdenCompra;";
        return $this->select($sql);
    }

    public function ListarDatos($id)
    {
        $sql = "SELECT * FROM detalle_ordencompra WHERE ID_USER = $id";
        return $this->selectAll($sql);
    }

    public function MostrarPDF($id)
    {
        $sql = "SELECT PDF FROM ordencompra WHERE ID = '$id'";
        $filename = "OC20D24DF.pdf";
        $data = $this->PDF($sql, $filename);
        return $data;
    }

    public function ListarOrdenCompra()
    {
        $sql = "SELECT ID, FECHA, AREA, NECESIDAD, CONCEPTO, TOTAL FROM ordencompra";
        return $this->selectAll($sql);
    }

    public function Verificar($id_rol, $id_permiso)
    {
        $sql = "SELECT d.ID_PERMISO FROM permisos p INNER JOIN detalle_permiso d ON d.ID_PERMISO = p.ID WHERE d.ID_ROL = $id_rol AND p.ID = $id_permiso";
        return $this->select($sql);
    }

}

?>