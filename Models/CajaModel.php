<?php
class CajaModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function ListarIngresos()
    {
        $sql = "SELECT * FROM ingreso WHERE IN_FECHA = CURDATE()";
        return $this->selectAll($sql);
    }

    public function ListarIngresosExcel()
    {
        $sql = "SELECT * FROM ingreso";
        return $this->selectAll($sql);
    }

    public function ListarEgresosExcel()
    {
        $sql = "SELECT * FROM salida";
        return $this->selectAll($sql);
    }

    public function ListarEgresos()
    {
        $sql = "SELECT * FROM salida WHERE SAL_FECHA = CURDATE()";
        return $this->selectAll($sql);
    }

    public function RegistrarIngreso($tranx, $com, $n, $respo, $tip, $des, $area, $monto)
    {
        $sql = "INSERT INTO ingreso (`IN_TRANSACCION`, `IN_COMPROBANTE`, `IN_NCOMPRO`, `IN_RESPONSABLE`, `IN_TIP_PAGO`, `IN_DESCRIPCION`, `IN_AREA`, `IN_MONTO`) VALUES (?,?,?,?,?,?,?,?)";
        $datos = array($tranx, $com, $n, $respo, $tip, $des, $area, $monto);
        return $this->insertar($sql, $datos);
    }

    public function MostraIngresos($id)
    {
        $sql = "SELECT * FROM ingreso WHERE IN_ID = $id";
        return $this->select($sql);
    }

    public function ModificarIngreso($id, $tranx, $com, $n, $respo, $tip, $des, $area, $monto)
    {
        $sql = "UPDATE ingreso SET `IN_TRANSACCION`= ?,`IN_COMPROBANTE`= ?,`IN_NCOMPRO`= ?,`IN_RESPONSABLE`= ?,`IN_TIP_PAGO`= ?,`IN_DESCRIPCION`= ?,`IN_AREA`= ?,`IN_MONTO`= ? WHERE `IN_ID` = ?";
        $datos = array($tranx, $com, $n, $respo, $tip, $des, $area, $monto, $id);
        return $this->save($sql, $datos);
    }

    public function EliminarIngreso($id)
    {
        $sql = "DELETE FROM ingreso WHERE IN_ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function MostraEgresos($id)
    {
        $sql = "SELECT * FROM salida WHERE SAL_ID = $id";
        return $this->select($sql);
    }

    public function RegistrarEgreso($tranx, $com, $n, $respo, $tip, $des, $area, $monto)
    {
        $sql = "INSERT INTO salida (`SAL_TRANSACCION`, `SAL_COMPROBANTE`, `SAL_NCOMPRO`, `SAL_RESPONSABLE`, `SAL_TIP_PAGO`, `SAL_DESCRIPCION`, `SAL_AREA`, `SAL_MONTO`) VALUES (?,?,?,?,?,?,?,?)";
        $datos = array($tranx, $com, $n, $respo, $tip, $des, $area, $monto);
        return $this->insertar($sql, $datos);
    }

    public function ModificarEgreso($id, $tranx, $com, $n, $respo, $tip, $des, $area, $monto)
    {
        $sql = "UPDATE salida SET `SAL_TRANSACCION`= ?,`SAL_COMPROBANTE`= ?,`SAL_NCOMPRO`= ?,`SAL_RESPONSABLE`= ?,`SAL_TIP_PAGO`= ?,`SAL_DESCRIPCION`= ?,`SAL_AREA`= ?,`SAL_MONTO`= ? WHERE `SAL_ID` = ?";
        $datos = array($tranx, $com, $n, $respo, $tip, $des, $area, $monto, $id);
        return $this->save($sql, $datos);
    }

    public function EliminarEgreso($id)
    {
        $sql = "DELETE FROM salida WHERE SAL_ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function CalcularIngresos()
    {
        $sql = "SELECT SUM(IN_MONTO) AS IN_TOTAL FROM ingreso";
        return $this->select($sql);
    }

    public function CalcularEgresos()
    {
        $sql = "SELECT SUM(SAL_MONTO) AS SAL_TOTAL FROM salida";
        return $this->select($sql);
    }

    public function TotalIngresoEgresos()
    {
        $sql = "CALL CalculaResta()";
        return $this->select($sql);
    }

    public function IdRecibo()
    {
        $sql = "SELECT MAX(ID) AS ID FROM ingreso_recibo";
        return $this->select($sql);
    }

    public function IdReciboEgreso()
    {
        $sql = "SELECT MAX(ID) AS ID FROM salida_recibo";
        return $this->select($sql);
    }

    public function RegistrarRecibo($id)
    {
        $sql = "INSERT INTO ingreso_recibo (`IN_ID`) VALUES (?)";
        $datos = array($id);
        return $this->insertar($sql, $datos);
    }

    public function RegistrarReciboEgreso($id)
    {
        $sql = "INSERT INTO salida_recibo (`SAL_ID`) VALUES (?)";
        $datos = array($id);
        return $this->insertar($sql, $datos);
    }

    public function DatosReciboID($id)
    {
        $sql = "SELECT * FROM ingreso_recibo WHERE IN_ID = $id";
        return $this->select($sql);
    }

    public function DatosReciboIDEgreso($id)
    {
        $sql = "SELECT * FROM salida_recibo WHERE SAL_ID = $id";
        return $this->select($sql);
    }

    public function ListarRecibos()
    {
        $sql = "SELECT r.ID, r.FECHA, i.IN_RESPONSABLE, i.IN_MONTO, r.IN_ID FROM ingreso_recibo r INNER JOIN ingreso i ON r.IN_ID = i.IN_ID";
        return $this->selectAll($sql);
    }

    public function ListarRecibosEgreso()
    {
        $sql = "SELECT r.ID, r.FECHA, s.SAL_RESPONSABLE, s.SAL_MONTO, r.SAL_ID FROM salida_recibo r INNER JOIN salida s ON r.SAL_ID = s.SAL_ID";
        return $this->selectAll($sql);
    }


    public function ListarIngresosCaja($fecha="")
    {
        if (!empty($fecha)) {
            $sql = "SELECT * FROM ingreso WHERE IN_FECHA = '$fecha'";
        } else{
            $sql = "SELECT * FROM ingreso WHERE IN_FECHA = CURDATE()";
        }
        
        return $this->selectAll($sql);
    }

    public function ListarEgresosCaja($fecha="")
    {
        if (!empty($fecha)) {
            $sql = "SELECT * FROM salida WHERE SAL_FECHA = '$fecha'";
        } else {
            $sql = "SELECT * FROM salida WHERE SAL_FECHA = CURDATE()";
        }
        
        return $this->selectAll($sql);
    }

    public function TotalIngresosCaja($fecha="")
    {
        if (!empty($fecha)) {
            $sql = "SELECT SUM(IN_MONTO) AS IN_MONTO, DATE_FORMAT(IN_FECHA, '%d, %b de %Y') AS IN_FECHA FROM ingreso WHERE IN_FECHA = '$fecha'";
        } else {
            $sql = "SELECT SUM(IN_MONTO) AS IN_MONTO, DATE_FORMAT(IN_FECHA, '%d, %b de %Y') AS IN_FECHA FROM ingreso WHERE IN_FECHA = CURDATE()";
        }
        
        return $this->select($sql);
    }

    public function TotalEgresosCaja($fecha="")
    {
        if (!empty($fecha)) {
            $sql = "SELECT SUM(SAL_MONTO) AS SAL_MONTO, DATE_FORMAT(SAL_FECHA, '%d, %b de %Y') AS SAL_FECHA FROM salida WHERE SAL_FECHA = '$fecha'";
        } else {
            $sql = "SELECT SUM(SAL_MONTO) AS SAL_MONTO, DATE_FORMAT(SAL_FECHA, '%d, %b de %Y') AS SAL_FECHA FROM salida WHERE SAL_FECHA = CURDATE()";
        }
        
        return $this->select($sql);
    }

    public function CerrarCaja($monto, $blob)
    {
        $sql = "INSERT INTO cerrar_caja (MONTO, PDF) VALUE(?,?)";
        $datos = array($monto, $blob);
        return $this->save($sql,$datos);
    }

    public function ListaResumenCaja()
    {
        $sql = "SELECT ID, FECHA, MONTO FROM cerrar_caja";
        return $this->selectAll($sql);
    }

    public function VerPDFCaja($id)
    {
        $sql = "SELECT PDF FROM cerrar_caja WHERE ID = $id";
        $filename = "CC20D23DG.pdf";
        $data = $this->PDF($sql, $filename);
        return $data;
    }

    public function EliminarResumenCaja($id)
    {
        $sql = "DELETE FROM cerrar_caja WHERE ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function Verificar($id_rol, $id_permiso)
    {
        $sql = "SELECT d.ID_PERMISO FROM permisos p INNER JOIN detalle_permiso d ON d.ID_PERMISO = p.ID WHERE d.ID_ROL = $id_rol AND p.ID = $id_permiso";
        return $this->select($sql);
    }
}

?>