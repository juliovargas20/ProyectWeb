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
        $sql = "SELECT c.ID_PACIENTE, c.SUB_TRAB, c.TIP_TRAB, c.CONSEN, r.NOMBRES FROM contratos c INNER JOIN registro r ON c.ID_PACIENTE = r.ID_PACIENTE WHERE c.TIP_TRAB = 'Miembro Inferior'";
        return $this->selectAll($sql);
    }

    public function getDatos($id)
    {
        $sql = "SELECT c.ID_PACIENTE, c.SUB_TRAB, r.NOMBRES, c.TIP_TRAB FROM contratos c INNER JOIN registro r ON c.ID_PACIENTE = r.ID_PACIENTE WHERE c.ID_PACIENTE = '$id'";
        return $this->select($sql);
    }

    public function RegistrarDatos($id, $tip, $sub)
    {
        $sql = "INSERT INTO consen (ID_PACIENTE, TIP_TRAB, SUB_TRAB) VALUES (?,?,?)";
        $datos = array($id, $tip, $sub);
        return $this->insertar($sql, $datos);
    }

    public function RegistrarLista($id, $item) 
    {
        $sql = "INSERT INTO list_consen (ID_CONSEN, ITEM) VALUES (?,?)";
        $datos = array($id, $item);
        return $this->save($sql, $datos);
    }

}

?>