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
        $sql = "SELECT * FROM productos WHERE SEDE = '$sede' ORDER BY PRO_CODIGO ASC";
        return $this->selectAll($sql);
    }

    public function InsertProduct($cod, $name, $des, $uni, $sede, $area, $stock)
    {

        $verificar = "SELECT PRO_CODIGO FROM productos WHERE PRO_CODIGO = '$cod'";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $sql = "INSERT INTO productos (`PRO_CODIGO`, `NOMBRE`, `DESCRIPCION`, `UNIDADES`, `SEDE`, `AREA`, `STOCK_MINIMO`) VALUES (?,?,?,?,?,?,?)";
            $datos = array($cod, $name, $des, $uni, $sede, $area, $stock);

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
        $sql = "SELECT * FROM productos WHERE PRO_ID = $id";
        return $this->select($sql);
    }

    public function UpdateProducts($id, $cod, $name, $des, $uni, $area, $stock)
    {
        $verificar = "SELECT PRO_CODIGO FROM productos WHERE PRO_CODIGO = '$cod'";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $sql = "UPDATE `productos` SET `PRO_CODIGO`= ?,`NOMBRE`= ?,`DESCRIPCION`= ?,`UNIDADES`= ?,`AREA`= ?,`STOCK_MINIMO`= ? WHERE PRO_ID = ?";
            $datos = array($cod, $name, $des, $uni, $area, $stock, $id);

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

    public function DeleteProduct($id)
    {
        $sql = "DELETE FROM productos WHERE PRO_ID = ?";
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
        $sql = "SELECT * FROM productos WHERE PRO_CODIGO = '$cod'";
        return $this->select($sql);
    }

    public function RegisterEntriesProducts($cod, $boleta, $qual)
    {
        $sql = "INSERT INTO `entradas`(`ENT_PRO_CODIGO`, `ENT_BOLETA`, `ENT_CANTIDAD`) VALUES (?,?,?)";
        $datos = array($cod, $boleta, $qual);
        return $this->insertar($sql, $datos);
    }

    public function RegistarSerieProducts($id_entries, $cod, $serie)
    {

        $verificar = "SELECT NSERIE FROM productos_serie WHERE NSERIE = '$serie'";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $sql = "INSERT INTO `productos_serie`(`PS_ENT_ID`, `PS_PRO_CODIGO`, `NSERIE`) VALUES (?,?,?)";
            $datos = array($id_entries, $cod, $serie);
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

    public function DeleteEntriesProductsAfterSerie($id_entries)
    {
        $sql = "DELETE FROM entradas WHERE ENT_ID = ?";
        $datos = array($id_entries);
        return $this->save($sql, $datos);
    }

    public function AllSerieProductCod($id)
    {
        $sql = "SELECT ps.*, p.NOMBRE FROM productos_serie ps INNER JOIN productos p ON ps.PS_PRO_CODIGO = p.PRO_CODIGO WHERE PS_ENT_ID = $id ";
        return $this->selectAll($sql);
    }

    /************** </PRODUCTOS LIMA> **************/
}
