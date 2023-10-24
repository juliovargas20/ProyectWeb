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
        $sql = "SELECT (SUM(IN_TOTAL) - SUM(SAL_TOTAL)) AS RESTA
        FROM (SELECT SUM(IN_MONTO) AS IN_TOTAL FROM ingreso) AS t1
        JOIN (SELECT SUM(SAL_MONTO) AS SAL_TOTAL FROM salida) AS t2";
        return $this->select($sql);
    }

    public function IdRecibo()
    {
        $sql = "SELECT MAX(ID) AS ID FROM ingreso_recibo";
        return $this->select($sql);
    }

    public function RegistrarRecibo($id)
    {
        $sql = "INSERT INTO ingreso_recibo (`IN_ID`) VALUES (?)";
        $datos = array($id);
        return $this->insertar($sql, $datos);
    }

    public function DatosReciboID($id)
    {
        $sql = "SELECT * FROM ingreso_recibo WHERE IN_ID = $id";
        return $this->select($sql);
    }

    public function ListarRecibos()
    {
        $sql = "SELECT r.ID, r.FECHA, i.IN_RESPONSABLE, i.IN_MONTO FROM ingreso_recibo r INNER JOIN ingreso i ON r.IN_ID = i.IN_ID";
        return $this->selectAll($sql);
    }
}

?>