<?php
class LogisticaModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function RegistarDetallePro($nombre, $pais, $tel_pro, $pagina, $ven, $tel_ven, $cantidad, $producto, $des, $link, $obs, $id_user, $moneda, $precio)
    {
        $sql = "INSERT INTO `detalle_proveedor`(`PRO_NOMBRE`, `PAIS`, `TEL_PRO`, `PAGINA`, `VENDEDOR`, `TEL_VENDEDOR`, `CANTIDAD`, `PRODUCTO`, `DESCRIPCION`, `LINK`, `OBSERVACION`, `ID_USER`, `MONEDA`, `PRECIO`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $datos = array($nombre, $pais, $tel_pro, $pagina, $ven, $tel_ven, $cantidad, $producto, $des, $link, $obs, $id_user, $moneda, $precio);
        return $this->save($sql, $datos);
    }

    public function Listar($id_user) 
    {
        $sql = "SELECT * FROM detalle_proveedor WHERE ID_USER = $id_user";
        return $this->selectAll($sql);
    }

    public function Mostrar($id)
    {
        $sql = "SELECT * FROM detalle_proveedor WHERE ID = $id";
        return $this->select($sql);
    }

    public function Modificar($id, $nombre, $pais, $tel_pro, $pagina, $ven, $tel_ven, $cantidad, $producto, $des, $link, $obs, $moneda, $precio) 
    {
        $sql = "UPDATE `detalle_proveedor` SET `PRO_NOMBRE`= ?,`PAIS`= ?,`TEL_PRO`= ?,`PAGINA`= ?,`VENDEDOR`= ?,`TEL_VENDEDOR`= ?,`CANTIDAD`= ?,`PRODUCTO`= ?,`DESCRIPCION`= ?,`LINK`= ?,`OBSERVACION`= ?,`MONEDA`= ?,`PRECIO`= ? WHERE ID = ?";
        $datos = array($nombre, $pais, $tel_pro, $pagina, $ven, $tel_ven, $cantidad, $producto, $des, $link, $obs, $moneda, $precio, $id);
        return $this->save($sql, $datos);
    }

    public function Eliminar($id)
    {
        $sql = "DELETE FROM detalle_proveedor WHERE ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function getDatos($id)
    {
        $sql = "SELECT * FROM detalle_proveedor WHERE ID_USER = $id";
        return $this->selectAll($sql);
    }

    public function RegistrarImportacion($area, $blob)
    {
        $sql = "INSERT INTO `importacion`(`AREA`, `PDF`) VALUES (?,?)";
        $sql2 = "SELECT MAX(ID) FROM importacion";
        $datos = array($area, $blob);
        return $this->getIDString($sql, $datos, $sql2);
    }

    public function MaxAu3()
    {
        $sql = "SELECT CONCAT('OI', LPAD(IFNULL(MAX(CONVERT(SUBSTRING(ID, 3), SIGNED INTEGER)), 0) + 1, 6, '0')) AS nuevo_numero FROM importacion;";
        return $this->select($sql);
    }

    public function MostrarPdf($id)
    {
        $sql = "SELECT PDF FROM importacion WHERE ID = '$id'";
        $filename = "OI20D24DF.pdf";
        $data = $this->PDF($sql, $filename);
        return $data;
    }

    public function EliminarDetalles($id)
    {
        $sql = "DELETE FROM detalle_proveedor WHERE ID_USER = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function ListarImportaciones()
    {
        $sql = "SELECT ID, FECHA, AREA FROM importacion";
        return $this->selectAll($sql);
    }

}

?>