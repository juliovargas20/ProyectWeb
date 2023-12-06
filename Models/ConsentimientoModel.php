<?php

use PhpOffice\PhpSpreadsheet\Writer\Ods\Thumbnails;

class ConsentimientoModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function Verificar($id_rol, $id_permiso)
    {
        $sql = "SELECT d.ID_PERMISO FROM permisos p INNER JOIN detalle_permiso d ON d.ID_PERMISO = p.ID WHERE d.ID_ROL = $id_rol AND p.ID = $id_permiso";
        return $this->select($sql);
    }

    public function Listar()
    {
        $sql = "SELECT c.ID_PACIENTE, c.SUB_TRAB, c.TIP_TRAB, c.CONSEN, r.NOMBRES, C.ID FROM contratos c INNER JOIN registro r ON c.ID_PACIENTE = r.ID_PACIENTE WHERE c.TIP_TRAB = 'Miembro Inferior' ORDER BY c.ID_PACIENTE DESC";
        return $this->selectAll($sql);
    }

    public function getDatos($id)
    {
        $sql = "SELECT c.ID_PACIENTE, c.SUB_TRAB, r.NOMBRES, c.TIP_TRAB, c.ID FROM contratos c INNER JOIN registro r ON c.ID_PACIENTE = r.ID_PACIENTE WHERE c.ID_PACIENTE = '$id'";
        return $this->select($sql);
    }

    public function RegistrarDatos($id_con, $id, $tip, $sub)
    {
        $sql = "INSERT INTO consen (ID_CONTRATO, ID_PACIENTE, TIP_TRAB, SUB_TRAB) VALUES (?,?,?,?)";
        $datos = array($id_con, $id, $tip, $sub);
        return $this->insertar($sql, $datos);
    }

    public function UpdateConsen($id)
    {
        $sql = "UPDATE contratos SET CONSEN = ? WHERE ID = ?";
        $datos = array(1, $id);
        return $this->save($sql, $datos);
    }

    public function RegistrarLista($id, $item) 
    {
        $sql = "INSERT INTO list_consen (ID_CONSEN, ITEM) VALUES (?,?)";
        $datos = array($id, $item);
        return $this->save($sql, $datos);
    }

    public function getDatosCarta($id)
    {
        $sql = "SELECT c.ID_PACIENTE, c.SUB_TRAB, r.NOMBRES, r.SEDE, r.DNI, r.DIRECCION FROM consen c INNER JOIN registro r ON c.ID_PACIENTE = r.ID_PACIENTE WHERE ID = $id";
        return $this->select($sql);
    }

    public function getIDPA($id)
    {
        $sql = "SELECT * FROM consen WHERE ID_CONTRATO = $id";
        return $this->select($sql);
    }

    public function getLista($id)
    {
        $sql = "SELECT * FROM list_consen WHERE ID_CONSEN = $id";
        return $this->selectAll($sql);
    }

}

?>