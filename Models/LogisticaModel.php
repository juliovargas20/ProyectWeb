<?php
class LogisticaModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    /************** <IMPORTACIONES> **************/

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

    public function ObtenerContenidoPdf($id)
    {
        $sql = "SELECT PDF FROM importacion WHERE ID = '$id'";
        $data = $this->select($sql);
        // Obtener el contenido del PDF desde la consulta
        return $data['PDF'];
    }

    public function EliminarDetalles($id)
    {
        $sql = "DELETE FROM detalle_proveedor WHERE ID_USER = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function ListarImportaciones()
    {
        $sql = "SELECT ID, FECHA, AREA, STATUS FROM importacion";
        return $this->selectAll($sql);
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE importacion SET STATUS = ? WHERE ID = ?";
        $datos = array($status, $id);
        return $this->save($sql, $datos);
    }

    public function updateStatusCompra($id, $status)
    {
        $sql = "UPDATE ordencompra SET STATUS = ? WHERE ID = ?";
        $datos = array($status, $id);
        return $this->save($sql, $datos);
    }

    public function ListarOrdenCompra()
    {
        $sql = "SELECT ID, FECHA, AREA, NECESIDAD, CONCEPTO, TOTAL, STATUS FROM ordencompra";
        return $this->selectAll($sql);
    }

    public function Verificar($id_rol, $id_permiso)
    {
        $sql = "SELECT d.ID_PERMISO FROM permisos p INNER JOIN detalle_permiso d ON d.ID_PERMISO = p.ID WHERE d.ID_ROL = $id_rol AND p.ID = $id_permiso";
        return $this->select($sql);
    }

    /************** </IMPORTACIONES> **************/


    /************** </PRODUCTOS LIMA> **************/

    public function AllProducts($sede)
    {
        $sql = "SELECT * FROM productos p INNER JOIN inventario i ON p.ID_PRODUCTO = i.ID_PRODUCTO WHERE i.SEDE = '$sede' ORDER BY p.ID_PRODUCTO ASC";
        return $this->selectAll($sql);
    }

    public function InsertProduct($cod, $name, $des, $uni, $sede, $area, $stock)
    {

        $verificar = "SELECT CODIGO_PRODUCTO FROM productos WHERE CODIGO_PRODUCTO = '$cod'";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $sql = "CALL InsertarProductoInventario(?,?,?,?,?,?,?)";
            $datos = array($cod, $name, $des, $uni, $stock, $sede, $area);

            $data = $this->save($sql, $datos);

            if ($data > 0) {
                $res = 'ok';
            } else {
                $res = 'error';
            }
        } else {
            $res = 'existe';
        }

        return $res;
    }

    public function SimpleProducts($id)
    {
        $sql = "SELECT * FROM productos p INNER JOIN inventario i ON p.ID_PRODUCTO = i.ID_PRODUCTO WHERE p.ID_PRODUCTO = $id";
        return $this->select($sql);
    }

    public function UpdateProducts($id, $cod, $name, $des, $uni, $area, $stock)
    {
        $sql = "CALL UpdateProductoInventario(?,?,?,?,?,?,?)";
        $datos = array($cod, $name, $des, $uni, $stock, $area, $id);

        $data = $this->save($sql, $datos);

        if ($data > 0) {
            $res = 'ok';
        } else {
            $res = 'error';
        }


        return $res;
    }

    public function DeleteProduct($id)
    {
        $sql = "DELETE FROM productos WHERE ID_PRODUCTO = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function AllEntriesProducts($sede)
    {
        $sql = "SELECT e.*, p.PRO_CODIGO, p.NOMBRE, p.DESCRIPCION, p.UNIDADES FROM entradas e INNER JOIN productos p ON e.ENT_PRO_CODIGO = p.PRO_CODIGO WHERE P.SEDE = '$sede'";
        return $this->selectAll($sql);
    }

    public function UnidProductsSearch($cod)
    {
        $sql = "SELECT UNIDADES FROM productos WHERE CODIGO_PRODUCTO = '$cod'";
        return $this->select($sql);
    }

    public function RegistarSerieProductsEntries($id_producto, $serie, $boleta, $qual)
    {

        $sql = "CALL Insert_ProductSerie_Entries(?,?,?,?)";
        $datos = array($id_producto, $serie, $boleta, $qual);
        return $this->save($sql, $datos);
    }

    public function AllSerieProductCod($id)
    {
        $sql = "SELECT ps.*, p.NOMBRE FROM productos_serie ps INNER JOIN productos p ON ps.PS_PRO_CODIGO = p.PRO_CODIGO WHERE PS_ENT_ID = $id ";
        return $this->selectAll($sql);
    }

    /************** </PRODUCTOS LIMA> **************/
}
