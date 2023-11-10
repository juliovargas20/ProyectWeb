<?php
class UsuariosModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }


    public function getUsuarios()
    {
        $sql = "SELECT U.*, C.ID as ID_CAJA, C.CAJA FROM usuarios U INNER JOIN caja C WHERE U.ID_CAJA = C.ID";
        return $this->selectAll($sql);
    }

    public function getUsuariosLogin($correo, $clave)
    {
        $sql = "SELECT * FROM usuarios WHERE USUARIOS = '$correo' AND PASSWORD = '$clave'";
        return $this->select($sql);
    }

    public function RegistrarUsuario($nombre, $correo, $clave, $rol)
    {
        $sql = "INSERT INTO usuarios (NOMBRES, USUARIOS, PASSWORD, ID_CAJA) VALUES (?,?,?,?)";
        $datos = array($nombre, $correo, $clave, $rol);
        return $this->save($sql, $datos);
    }

    public function Modificar($id, $nombre, $correo, $clave, $rol)
    {
        $sql = "UPDATE usuarios SET NOMBRES = ?, USUARIOS = ?, PASSWORD = ?, ID_CAJA = ? WHERE ID = ?";
        $datos = array($nombre, $correo, $clave, $rol, $id);
        return $this->save($sql, $datos);
    }

    public function MostrarUsuario($id)
    {
        $sql = "SELECT * FROM usuarios WHERE ID = $id";
        return $this->select($sql);
    }

    public function Inactivar($id)
    {
        $sql = "UPDATE usuarios set ESTADO = ? WHERE ID = ?";
        $datos = array(0, $id);
        return $this->save($sql, $datos);
    }

    public function Activar($id)
    {
        $sql = "UPDATE usuarios set ESTADO = ? WHERE ID = ?";
        $datos = array(1, $id);
        return $this->save($sql, $datos);
    }

    /**************** <ROLES Y PERMISOS> ****************/
    public function getCaja()
    {
        $sql = "SELECT * FROM caja";
        return $this->selectAll($sql);
    }

    public function getBCaja($id)
    {
        $sql = "SELECT * FROM caja WHERE ID = $id";
        return $this->select($sql);
    }

    public function getMaxCaja()
    {
        $sql = "SELECT MAX(ID) as ID FROM caja";
        return $this->select($sql);
    }

    public function getPermisos()
    {
        $sql = "SELECT * FROM permisos";
        return $this->selectAll($sql);
    }

    public function getBPermisos($id)
    {
        $sql = "SELECT * FROM detalle_permiso WHERE ID_ROL = $id";
        return $this->selectAll($sql);
    }

    public function EliminarPermiso($id_rol)
    {
        $sql = "DELETE FROM detalle_permiso WHERE ID_ROL = ?";
        $datos = array($id_rol);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = 'ok';
        }else{
            $res = 'error';
        }
        return $res;
    }

    public function UpdateRol($rol, $id)
    {
        $sql = "UPDATE caja SET CAJA = ? WHERE ID = ?";
        $datos = array($rol, $id);
        return $this->save($sql, $datos);
    }

    public function RegistrarRol($rol)
    {
        $sql = "INSERT INTO caja (CAJA) VALUES (?)";
        $datos = array($rol);
        return $this->save($sql, $datos);
    }

    public function RegistrarPermiso($id_rol, $id_permiso)
    {
        $sql = "INSERT INTO detalle_permiso (ID_ROL, ID_PERMISO) VALUES(?,?)";
        $datos = array($id_rol, $id_permiso);
        return $this->save($sql, $datos);
    }

    public function EliminarRol($id)
    {
        $sql = "UPDATE caja SET ESTADO = 0 WHERE ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }
    

    public function ActivarRol($id)
    {
        $sql = "UPDATE caja SET ESTADO = 1 WHERE ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    /**************** </ROLES Y PERMISOS> ****************/

    public function Verificar($id_rol, $id_permiso)
    {
        $sql = "SELECT d.ID_PERMISO FROM permisos p INNER JOIN detalle_permiso d ON d.ID_PERMISO = p.ID WHERE d.ID_ROL = $id_rol AND p.ID = $id_permiso";
        return $this->select($sql);
    }

}

?>