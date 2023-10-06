<?php
class CitasModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function ListarVisme()
    {
        $sql = "SELECT *, TIME_FORMAT(TIMEDIFF(SALIDA, INICIO), '%H horas') as horas FROM visme";
        return $this->selectAll($sql);
    }

    public function ListarOrtoP()
    {
        $sql = "SELECT *, TIME_FORMAT(TIMEDIFF(SALIDA, INICIO), '%H horas') as horas FROM ortopedia";
        return $this->selectAll($sql);
    }



    public function RegistrarCensa($inicio, $salida, $cenSa, $nombre, $time, $des, $conclu, $correo, $cel, $fechnac, $visitador)   
    {
        $sql = "INSERT INTO visme (INICIO, SALIDA, CENSALUD, NOMDOC, TIME, DESARROLLO, CONCLUSION, CORREO, CELULAR, FECHANAC, VISITADOR) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

        $datos = array($inicio, $salida, $cenSa, $nombre, $time, $des, $conclu, $correo, $cel, $fechnac, $visitador);

        return $this->save($sql, $datos);

    }

    public function MostrarCenSalud($id) 
    {
        $sql = "SELECT * FROM visme WHERE ID = $id";
        return $this->select($sql);
    }


    public function RegistrarOr($inicio, $salida, $tienda, $nombre, $time, $des, $conclu, $correo, $cel, $ruc, $visitador)
    {
        $sql = "INSERT INTO ortopedia (INICIO, SALIDA, TIENDA, NOMENC, TIME, DESAROLLO, CONCLUSION, CORREO, CELULAR, RUC, VISITADOR) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $datos = array($inicio, $salida, $tienda, $nombre, $time, $des, $conclu, $correo, $cel, $ruc, $visitador);
        return $this->save($sql, $datos);
    }

    public function MostrarOr($id) 
    {
        $sql = "SELECT * FROM ortopedia WHERE ID = $id";
        return $this->select($sql);
    }

    public function Verificar($id_rol, $id_permiso)
    {
        $sql = "SELECT d.ID_PERMISO FROM permisos p INNER JOIN detalle_permiso d ON d.ID_PERMISO = p.ID WHERE d.ID_ROL = $id_rol AND p.ID = $id_permiso";
        return $this->select($sql);
    }
}

?>