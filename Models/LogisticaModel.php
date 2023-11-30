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

}

?>