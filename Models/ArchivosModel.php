<?php
class ArchivosModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }


    public function Verificar($id_rol, $id_permiso)
    {
        $sql = "SELECT d.ID_PERMISO FROM permisos p INNER JOIN detalle_permiso d ON d.ID_PERMISO = p.ID WHERE d.ID_ROL = $id_rol AND p.ID = $id_permiso";
        return $this->select($sql);
    }
    
    public function Listado() 
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE";
        return $this->selectAll($sql);
    }

    public function getDatos($id)
    {
        $sql = "SELECT b.ID, b.ID_PACIENTE, r.NOMBRES, b.SUB_TRAB FROM base_historial b INNER JOIN registro r ON b.ID_PACIENTE = r.ID_PACIENTE WHERE b.ID = $id";
        return $this->select($sql);
    }

    public function ListarDocumentos($id)
    {
        $sql = "SELECT ID, ID_BASE, NOMBRES FROM archivo WHERE ID_BASE = $id";
        return $this->selectAll($sql);
    }

    public function RegistrarDocumento($id, $nombre, $blob, $tipo)
    {
        $sql = "INSERT INTO archivo (ID_BASE, NOMBRES, DOCUMENTO, TIPO) VALUES (?,?,?,?)";
        $datos = array($id, $nombre, $blob, $tipo);
        return $this->save($sql, $datos);
    }

    public function MostrarDocumento($id)
    {
        $sql = "SELECT DOCUMENTO, TIPO FROM archivo WHERE ID = $id";
        $filename = "comprobante_$id.jpg";
        return $this->downloadImage($sql,$filename, 'DOCUMENTO');
    }

    public function EliminarDocumento($id)
    {
        $sql = "DELETE FROM archivo WHERE ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

}

?>