<?php
class HistorialModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }


    /*************** LISTADO DE PACIENTES ***************/
    public function ListarMS1()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Miembro Superior' AND b.PROCESO = 1";
        return $this->selectAll($sql);
    }

    public function ListarMS2()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Miembro Superior' AND b.PROCESO = 2";
        return $this->selectAll($sql);
    }

    public function ListarMS3()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Miembro Superior' AND b.PROCESO = 3";
        return $this->selectAll($sql);
    }

    public function ListarMS4()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Miembro Superior' AND b.PROCESO = 4";
        return $this->selectAll($sql);
    }





    public function ListarMI1()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Miembro Inferior' AND b.PROCESO = 1";
        return $this->selectAll($sql);
    }

    public function ListarMI2()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Miembro Inferior' AND b.PROCESO = 2";
        return $this->selectAll($sql);
    }

    public function ListarMI3()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Miembro Inferior' AND b.PROCESO = 3";
        return $this->selectAll($sql);
    }

    public function ListarMI4()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Miembro Inferior' AND b.PROCESO = 4";
        return $this->selectAll($sql);
    }




    public function ListarE1()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Estetica' AND b.PROCESO = 1";
        return $this->selectAll($sql);
    }

    public function ListarE2()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Estetica' AND b.PROCESO = 2";
        return $this->selectAll($sql);
    }

    public function ListarE3()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Estetica' AND b.PROCESO = 3";
        return $this->selectAll($sql);
    }

    public function ListarE4()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.TIP_TRAB = 'Estetica' AND b.PROCESO = 4";
        return $this->selectAll($sql);
    }


    /*************** REGISTRO DE HISTORIAL ***************/
    public function getDatos($id)
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.TIP_TRAB, b.SUB_TRAB, b.PROCESO FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.ID = $id";
        return $this->select($sql);
    }

    public function getIDHisto()
    {
        $sql = "SELECT MAX(ID) AS ID FROM historial";
        return $this->select($sql);
    }

    public function RegistrarHistorial($id_base, $id, $des, $tec, $proceso)
    {
        $fecha = date('Y-m-d');

        $sql = "INSERT INTO historial (ID_BASE, ID_PACIENTE, FECHACITA, DESCRIPCION, TECNICO, PROCESO) VALUES (?,?,?,?,?,?)";

        $datos = array($id_base, $id, $fecha, $des, $tec, $proceso);

        return $this->save($sql, $datos);
    }

    public function RegistrarImg($max, $id, $img, $type, $name, $proceso)
    {
        $sql = "INSERT INTO historial_img (ID_HISTORIAL, ID_PACIENTE, IMG, TIPO, NOMBRE, PROCESO) VALUES (?,?,?,?,?,?)";
        $datos = array($max, $id, $img, $type, $name, $proceso);
        return $this->save($sql, $datos);
    }

    public function ListarHistorual($id, $proceso)
    {
        $sql = "SELECT * FROM historial WHERE ID_BASE = $id AND PROCESO = $proceso ORDER BY ID DESC";
        return $this->selectAll($sql);
    }


    public function Proceso2($id, $proceso)
    {

        $sql = "UPDATE base_historial SET PROCESO = 2 WHERE ID = ? AND PROCESO = ?";
        $datos = array($id, $proceso);

        return  $this->save($sql, $datos);
    }

    public function Proceso3($id, $proceso)
    {

        $sql = "UPDATE base_historial SET PROCESO = 3 WHERE ID = ? AND PROCESO = ?";
        $datos = array($id, $proceso);

        return  $this->save($sql, $datos);
    }

    public function Proceso4($id, $proceso)
    {

        $sql = "UPDATE base_historial SET PROCESO = 4 WHERE ID = ? AND PROCESO = ?";
        $datos = array($id, $proceso);

        return  $this->save($sql, $datos);
    }

    public function ProcesoFinal($id, $proceso)
    {

        $sql = "UPDATE base_historial SET PROCESO = 10 WHERE ID = ? AND PROCESO = ?";
        $datos = array($id, $proceso);

        return  $this->save($sql, $datos);
    }


    public function Resumen($id, $proceso)
    {
        $sql = "SELECT * FROM historial WHERE ID_BASE = $id AND PROCESO = $proceso ORDER BY ID DESC";
        return $this->selectAll($sql);
    }


    public function Listfinal()
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.TIP_TRAB, b.SUB_TRAB, b.PROCESO FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE PROCESO = 10";
        return $this->selectAll($sql);
    }

    public function Verificar($id_rol, $id_permiso)
    {
        $sql = "SELECT d.ID_PERMISO FROM permisos p INNER JOIN detalle_permiso d ON d.ID_PERMISO = p.ID WHERE d.ID_ROL = $id_rol AND p.ID = $id_permiso";
        return $this->select($sql);
    }
}
