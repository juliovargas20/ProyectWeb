<?php
class PacientesModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    /************** <LISTADO DE PACIENTES> **************/
    public function Listado()
    {
        $sql = "SELECT ID_PACIENTE, FECHA, NOMBRES, DNI, GENERO, CELULAR, DIRECCION, LOCACION, EDAD, SEDE, ESTADO, TIME_AMP, CANAL, MOTIVO, OBSERVACION, CORREO, FECHANAC, AFECCIONES, ALERGIAS FROM registro";
        return $this->selectAll($sql);
    }

    public function EliminarPaciente($id)
    {
        $sql = "DELETE FROM registro WHERE ID_PACIENTE = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function CambioEstadoContrato($id) 
    {
        $sql = "UPDATE registro SET ESTADO = 'Contrato' WHERE ID_PACIENTE = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function CambioEstadoCotizacion($id) 
    {
        $sql = "UPDATE registro SET ESTADO = 'Cotización' WHERE ID_PACIENTE = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function CambioEstadoDonacion($id) 
    {
        $sql = "UPDATE registro SET ESTADO = 'Donación' WHERE ID_PACIENTE = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function CambioEstadoEsSalud($id) 
    {
        $sql = "UPDATE registro SET ESTADO = 'Es Salud' WHERE ID_PACIENTE = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function CambioEstadoAccesorios($id) 
    {
        $sql = "UPDATE registro SET ESTADO = 'Accesorios' WHERE ID_PACIENTE = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    /************** </LISTADO DE PACIENTES> **************/



    /************** <REGISTRO DE PACIENTES> **************/

    public function Registrar($nombre, $dni, $genero, $edad, $celular, $naci, $dire, $sede, $local, $correo, $estado, $canal, $time, $motivo, $afec, $aler, $obs)
    {
        $fecha = date('Y-m-d');
        $sql = "INSERT INTO registro (FECHA, NOMBRES, DNI, GENERO, CELULAR, DIRECCION, LOCACION, EDAD, SEDE, ESTADO, TIME_AMP, CANAL, MOTIVO, OBSERVACION, CORREO, FECHANAC, AFECCIONES, ALERGIAS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $datos = array($fecha, $nombre, $dni, $genero, $celular, $dire, $local, $edad, $sede, $estado, $time, $canal, $motivo, $obs, $correo, $naci, $afec, $aler);
        return $this->save($sql, $datos);
    }

    /************** </REGISTRO DE PACIENTES> **************/



    /************** <MODIFICAR DE PACIENTES> **************/


    public function Mostrar($id)
    {
        $sql = "SELECT ID_PACIENTE, FECHA, NOMBRES, DNI, GENERO, CELULAR, DIRECCION, LOCACION, EDAD, SEDE, ESTADO, TIME_AMP, CANAL, MOTIVO, OBSERVACION, CORREO, FECHANAC, AFECCIONES, ALERGIAS FROM registro WHERE ID_PACIENTE = '$id'";
        return $this->select($sql);
    }

    public function Modificar($id, $nombre, $dni, $genero, $edad, $celular, $naci, $dire, $sede, $local, $correo, $estado, $canal, $time, $motivo, $afec, $aler, $obs)
    {
        $sql = "UPDATE registro SET NOMBRES = ?, DNI = ?, GENERO = ?, CELULAR = ?, DIRECCION = ?, LOCACION = ?, EDAD = ?, SEDE = ?, ESTADO = ?, TIME_AMP = ?, CANAL = ?, MOTIVO = ?, OBSERVACION = ?, CORREO = ?, FECHANAC = ?, AFECCIONES = ?, ALERGIAS = ? WHERE ID_PACIENTE = ?";
        $datos = array($nombre, $dni, $genero, $celular, $dire, $local, $edad, $sede, $estado, $time, $canal, $motivo, $obs, $correo, $naci, $afec, $aler, $id);
        return $this->save($sql, $datos);
    }

    /************** </MODIFICAR DE PACIENTES> **************/


    /************** <ACCESORIOS> **************/

    public function InsertDetallePago($id_user, $id_pa, $des, $can, $pre, $sub)
    {
        $sql = "INSERT INTO detalle_pago (ID_USER, ID_PACIENTE, DESCRIPCION, CANTIDAD, PRECIO_U, SUB_TOTAL) VALUE (?,?,?,?,?,?)";
        $datos = array($id_user, $id_pa, $des, $can, $pre, $sub);
        return $this->save($sql, $datos);
    }

    public function ListaDetallePago($id_user, $id_pa)
    {
        $sql = "SELECT * FROM detalle_pago WHERE ID_USER = $id_user AND ID_PACIENTE = '$id_pa'";
        return $this->selectAll($sql);
    }

    public function EliminarDetalle($id)
    {
        $sql = "DELETE FROM detalle_pago WHERE ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function CalcularTotalAcc($id_user, $id_pa)
    {
        $sql = "SELECT SUM(SUB_TOTAL) AS TOTAL FROM detalle_pago WHERE ID_USER = $id_user AND ID_PACIENTE = '$id_pa'";
        return $this->select($sql);
    }

    public function EliminarTodosDetalles($id_user, $id_pa)
    {
        $sql = "DELETE FROM detalle_pago WHERE ID_USER = ? AND ID_PACIENTE = ?";
        $datos = array($id_user, $id_pa);
        return $this->save($sql, $datos);
    }

    public function RealizarPago($id, $tip, $pago, $total, $obs, $blob, $id_user)
    {
        $sql = "INSERT INTO pagos (ID_PACIENTE, TIP_PAGO, PAGO, TOTAL, OBSERVACION, PDF, ID_USER) VALUES (?,?,?,?,?,?,?)";
        $datos = array($id, $tip, $pago, $total, $obs, $blob, $id_user);
        return $this->insertar($sql, $datos);
    }

    public function Maxpagos()
    {
        $sql = "SELECT MAX(ID) AS ID FROM pagos";
        return $this->select($sql);
    }

    public function MostrarReciboPagos($id)
    {
        $sql = "SELECT PDF FROM pagos WHERE ID = $id";
        $filename = "RPA20D23DF.pdf";
        $data = $this->PDF($sql, $filename);
        return $data;
    }

    public function ListarRecibos()
    {
        $sql = "SELECT p.ID, p.FECHA, p.ID_PACIENTE, p.TIP_PAGO, p.PAGO, p.TOTAL, r.NOMBRES, u.NOMBRES AS USUARIO FROM pagos p INNER JOIN registro r ON p.ID_PACIENTE = r.ID_PACIENTE INNER JOIN usuarios u ON p.ID_USER = u.ID";
        return $this->selectAll($sql);
    }

    /************** </ACCESORIOS> **************/

    /************** <COMPRAS> **************/

    public function InsertDetalleCompras($id_user, $des, $can, $pre, $sub)
    {
        $sql = "INSERT INTO detalle_compras (ID_USER, DESCRIPCION, CANTIDAD, PRECIO_U, SUB_TOTAL) VALUE (?,?,?,?,?)";
        $datos = array($id_user, $des, $can, $pre, $sub);
        return $this->save($sql, $datos);
    }

    public function ListaDetalleCompras($id_user)
    {
        $sql = "SELECT * FROM detalle_compras WHERE ID_USER = $id_user";
        return $this->selectAll($sql);
    }

    public function EliminarDetalleCompras($id)
    {
        $sql = "DELETE FROM detalle_compras WHERE ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function CalcularTotalCompras($id_user)
    {
        $sql = "SELECT SUM(SUB_TOTAL) AS TOTAL FROM detalle_compras WHERE ID_USER = $id_user";
        return $this->select($sql);
    }
    
    public function RealizarPagoCompras($nombres, $dni, $tip, $pago, $total, $obs, $blob)
    {
        $sql = "INSERT INTO compras (NOMBRES, DNI, TIP_PAGO, PAGO, TOTAL, OBSERVACION, PDF) VALUES (?,?,?,?,?,?,?)";
        $datos = array($nombres, $dni, $tip, $pago, $total, $obs, $blob);
        return $this->insertar($sql, $datos);
    }

    public function EliminarTodosDetallesCompras($id_user)
    {
        $sql = "DELETE FROM detalle_compras WHERE ID_USER = ?";
        $datos = array($id_user);
        return $this->save($sql, $datos);
    }

    public function getDatosCompras($id)
    {
        $sql = "SELECT FECHA, NOMBRES, DNI, TOTAL FROM compras WHERE ID = $id";
        return $this->select($sql);
    }

    public function getListaCompras($id_user)
    {
        $sql = "SELECT * FROM detalle_compras WHERE ID_USER = $id_user";
        return $this->selectAll($sql);
    }

    public function MaxCompras()
    {
        $sql = "SELECT MAX(ID) AS ID FROM compras";
        return $this->select($sql);
    }

    public function MostrarReciboCompras($id)
    {
        $sql = "SELECT PDF FROM compras WHERE ID = $id";
        $filename = "RCOM20D23DF.pdf";
        $data = $this->PDF($sql, $filename);
        return $data;
    }

    public function ListarReciboCompras()
    {
        $sql = "SELECT ID, FECHA, NOMBRES, DNI, TIP_PAGO, PAGO, TOTAL, OBSERVACION FROM compras";
        return $this->selectAll($sql);
    }

    /************** </COMPRAS> **************/

    public function Verificar($id_rol, $id_permiso)
    {
        $sql = "SELECT d.ID_PERMISO FROM permisos p INNER JOIN detalle_permiso d ON d.ID_PERMISO = p.ID WHERE d.ID_ROL = $id_rol AND p.ID = $id_permiso";
        return $this->select($sql);
    }

}

?>