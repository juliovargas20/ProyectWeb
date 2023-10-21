<?php
class CotizacionModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function ListarCotizacion()
    {
        $sql = "SELECT c.ID_PACIENTE, c.FECHA, r.NOMBRES, c.ID, c.MONTO, c.SUB_TRAB FROM cotizacion c INNER JOIN registro r ON c.ID_PACIENTE = r.ID_PACIENTE";
        return $this->selectAll($sql);
    }

    public function getPacientes()
    {
        $sql = "SELECT ID_PACIENTE, NOMBRES FROM registro ORDER BY ID_PACIENTE DESC";
        return $this->selectAll($sql);
    }

    public function getTipService()
    {
        $sql = "SELECT * FROM tipomiembro";
        return $this->selectAll($sql);
    }

    public function getSubTrab($id)
    {
        $sql = "SELECT * FROM subtrabajo s INNER JOIN tipomiembro t ON s.id_tipo = t.Id WHERE t.TIPOMIEMBRO = '$id'";
        return $this->selectAll($sql);
    }

    public function EliminarCoti($id)
    {
        $sql = "DELETE FROM cotizacion WHERE ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    /************** <!-- REGISTRAR COTIZACION --> **************/

    public function Existe($id)
    {
        $sql = "SELECT SUB_TRAB FROM trabajo WHERE ID_PACIENTE = '$id'";
        return $this->selectAll($sql);
    }

    public function IdCoti()
    {
        $sql = "SELECT MAX(ID) AS ID FROM cotizacion";
        return $this->select($sql);
    }

    public function RegistrarSer($id, $Ser, $Trab)
    {
        $sql = "INSERT INTO trabajo (ID_PACIENTE, TIP_TRAB, SUB_TRAB) VALUES (?,?,?)";
        $datos = array($id, $Ser, $Trab);

        return $this->save($sql, $datos);
    }

    public function RegistrarCoti($id, $monto, $obs, $ser, $tra, $peso, $igv, $cant)
    {
        $fecha = date('Y-m-d');
        $sql = "INSERT INTO cotizacion (ID_PACIENTE, FECHA, MONTO, OBSERVACION, TIP_TRAB, SUB_TRAB, PESO, IGV, CANTIDAD) VALUES (?,?,?,?,?,?,?,?,?)";
        $datos = array($id, $fecha, $monto, $obs, $ser, $tra, $peso, $igv, $cant);

        return $this->insertar($sql, $datos);
    }

    public function RegistrarLista($max, $list)
    {
        $sql = "INSERT INTO lista_cotizacion (ID_COTI, LISTA) VALUES (?,?)";
        $datos = array($max, $list);

        return $this->save($sql, $datos);
    }


    /************** <!-- /REGISTRAR COTIZACION --> **************/



    /************** <!-- IMPRIMIR COTIZACION --> **************/

    public function MostraListaCoti($id)
    {
        $sql = "SELECT LISTA FROM lista_cotizacion WHERE ID_COTI = $id";
        return $this->selectAll($sql);
    }        

    public function getImprimir($id)
    {
        $sql = "SELECT c.ID, c.ID_PACIENTE, c.MONTO, r.NOMBRES, c.SUB_TRAB, r.DIRECCION, r.CELULAR, c.TIP_TRAB, c.OBSERVACION, c.IGV, c.CANTIDAD FROM cotizacion c INNER JOIN registro r ON c.ID_PACIENTE = r.ID_PACIENTE WHERE c.ID = $id";
        return $this->select($sql);
    }

    /************** <!-- /IMPRIMIR COTIZACION --> **************/

    public function Verificar($id_rol, $id_permiso)
    {
        $sql = "SELECT d.ID_PERMISO FROM permisos p INNER JOIN detalle_permiso d ON d.ID_PERMISO = p.ID WHERE d.ID_ROL = $id_rol AND p.ID = $id_permiso";
        return $this->select($sql);
    }

}
?>