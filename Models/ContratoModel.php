<?php
class ContratoModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getPaciente($id)
    {
        $sql = "SELECT NOMBRES, ID_PACIENTE FROM registro WHERE ID_PACIENTE = '$id'";
        return $this->select($sql);
    }

    public function getLista($id)
    {
        $sql = "SELECT ID, ID_PACIENTE, FECHA, MONTO, SUB_TRAB, OBSERVACION FROM cotizacion WHERE ID_PACIENTE = '$id'";
        return $this->selectAll($sql);
    }

    
    public function ListaComponente($id)
    {
        $sql = "SELECT LISTA FROM lista_cotizacion WHERE ID_COTI = $id";
        return $this->selectAll($sql);
    }

    public function getContrato($id)
    {
        $sql = "SELECT ID, ID_PACIENTE, MONTO, TIP_TRAB, SUB_TRAB FROM cotizacion WHERE ID = $id";
        return $this->select($sql);
    }

    /********** REGISTRAR CONTRATO **********/

    public function RegistrarContrato($id, $ser, $tip, $monto, $blob)
    {
        $fecha = date('Y-m-d');

        $sql = "INSERT INTO contratos (FECHA, ID_PACIENTE, TIP_TRAB, SUB_TRAB, MONTO, PDF) VALUES (?,?,?,?,?,?)";
        $datos = array($fecha, $id, $ser, $tip, $monto, $blob);

        return $this->insertar($sql, $datos);
    }

    public function getDatosCotizacion($id)
    {
        $sql = "SELECT r.NOMBRES, c.ID_PACIENTE, r.DNI, c.SUB_TRAB, c.OBSERVACION, c.TIP_TRAB, c.MONTO, r.SEDE, c.PESO, c.CANTIDAD FROM cotizacion c INNER JOIN registro r ON c.ID_PACIENTE = r.ID_PACIENTE WHERE c.ID = $id";
        return $this->select($sql);
    }

    public function getListaComponentes($id)
    {
        $sql = "SELECT LISTA FROM lista_cotizacion WHERE ID_COTI = $id";
        return $this->selectAll($sql);
    }

    public function getDatosMailer($id)
    {
        $sql = "SELECT c.ID, c.FECHA, c.ID_PACIENTE, c.SUB_TRAB, c.TIP_TRAB, r.NOMBRES, r.DNI, r.CORREO FROM contratos c INNER JOIN registro r ON c.ID_PACIENTE = r.ID_PACIENTE WHERE c.ID = $id";
        return $this->select($sql);
    }


    /********** PAGOS DE CONTRATO **********/

    public function ListaContrato()
    {
        $sql = "SELECT c.FECHA, c.ID, c.ID_PACIENTE, c.SUB_TRAB, c.MONTO, r.NOMBRES, c.ESTADO FROM contratos c INNER JOIN registro r ON c.ID_PACIENTE = r.ID_PACIENTE";
        return $this->selectAll($sql);
    }

    public function getDatos($id)
    {
        $sql = "SELECT c.ID, c.ID_PACIENTE, c.SUB_TRAB, c.MONTO, r.NOMBRES FROM contratos c INNER JOIN registro r ON c.ID_PACIENTE = r.ID_PACIENTE WHERE c.ID = $id";
        return $this->select($sql);
    }
    

    public function SaldoPagos($id)
    {
        $sql = "SELECT c.MONTO - SUM(p.ABONO) AS TOTAL, SUM(p.ABONO) AS ABONO FROM pagoscontrato p INNER JOIN contratos c ON p.ID_CONTRATO = c.ID WHERE p.ID_CONTRATO = $id";
        return $this->select($sql);
    }

    public function MontoAbonado($id)
    {
        $sql = "SELECT MONTO FROM contratos WHERE ID = $id";
        return $this->select($sql);
    }

    public function RegistroPago($id_contrato, $id_paciente, $npago, $abono, $tipPago, $metodo, $comprobante)
    {

        $verificar = "SELECT NPAGO FROM pagoscontrato WHERE NPAGO = '$npago' AND ID_CONTRATO = $id_contrato";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $sql = "INSERT INTO pagoscontrato (ID_CONTRATO, ID_PACIENTE, NPAGO, ABONO, TIP_PAGO, METODO, COMPROBANTE) VALUES (?,?,?,?,?,?,?)";
            $datos = array($id_contrato, $id_paciente, $npago, $abono, $tipPago, $metodo, $comprobante);

            $data = $this->insertar($sql, $datos);

            if ($data > 0) {
                $res = $data;
            }else{
                $res = 'error';
            }

        }else{
            $res = 'existe';
        }
        return $res;
    }

    public function EliminarPago($id)
    {
        $sql = "DELETE FROM pagoscontrato WHERE ID = ?";
        $datos = array($id);
        return $this->save($sql, $datos);
    }

    public function ListarPagos($id)
    {
        $sql = "SELECT ID, ID_CONTRATO, ID_PACIENTE, FECHA, NPAGO, ABONO, TIP_PAGO, METODO FROM pagoscontrato WHERE ID_CONTRATO = $id";
        return $this->selectAll($sql);
    }

    public function MostrarComprobante($id)
    {
        $sql = "SELECT COMPROBANTE, TIPO FROM pagoscontrato WHERE ID = $id";
        $filename = "comprobante_$id.jpg";
        return $this->downloadImage($sql,$filename, 'COMPROBANTE');
    }

    public function getDatosRecibo($id)
    {
        $sql = "SELECT p.ID, p.FECHA, r.NOMBRES, r.DNI, p.NPAGO, p.ID_PACIENTE, p.ID_CONTRATO FROM pagoscontrato p INNER JOIN registro r ON p.ID_PACIENTE = r.ID_PACIENTE WHERE p.ID = $id";
        return $this->select($sql);
    }

    public function getDatosContrato($id)
    {
        $sql = "SELECT c.MONTO, c.SUB_TRAB, c.FECHA FROM pagoscontrato p INNER JOIN contratos c ON p.ID_CONTRATO = c.ID WHERE p.ID = $id";
        return $this->select($sql);
    }

    public function getRowPagos($id, $id_contrato)
    {
        $sql = "SELECT NPAGO, FECHA, ABONO FROM pagoscontrato WHERE ID_PACIENTE = '$id' AND ID_CONTRATO = $id_contrato";
        return $this->selectAll($sql);
    }

    public function getSaldos($id, $id_contrato)
    {
        $sql = "SELECT c.MONTO - SUM(p.ABONO) AS TOTAL FROM pagoscontrato p INNER JOIN contratos c ON p.ID_CONTRATO = c.ID WHERE p.ID_PACIENTE = '$id' AND p.ID_CONTRATO = $id_contrato";
        return $this->select($sql);
    }


    public function RegistrarPdfPago($id, $pdf)
    {
        $sql = "UPDATE pagoscontrato SET PDF = ? WHERE ID = ?";
        $datos = array($pdf, $id);
        return $this->save($sql, $datos);
    }

    public function MostrarRecibo($id)
    {
        $sql = "SELECT PDF FROM pagoscontrato WHERE ID = $id";
        $filename = "RP20D23DF.pdf";
        $data = $this->PDF($sql, $filename);
        return $data;
    }

    public function MostrarContrato($id)
    {
        $sql = "SELECT PDF FROM contratos WHERE ID = $id";
        $filename = "CO20D23DF.pdf";
        $data = $this->PDF($sql, $filename);
        return $data;
    }

    public function Verificar($id_rol, $id_permiso)
    {
        $sql = "SELECT d.ID_PERMISO FROM permisos p INNER JOIN detalle_permiso d ON d.ID_PERMISO = p.ID WHERE d.ID_ROL = $id_rol AND p.ID = $id_permiso";
        return $this->select($sql);
    }

}
