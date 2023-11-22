<?php
class Query extends Conexion
{
    private $pdo, $con, $sql, $datos;
    public function __construct()
    {
        $this->pdo = new Conexion();
        $this->con = $this->pdo->conect();
    }
    public function select(string $sql)
    {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function selectAll(string $sql)
    {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function save(string $sql, array $datos)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $res = 1;
        } else {
            $res = 0;
        }
        return $res;
    }

    public function insertar(string $sql, array $datos)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $res = $this->con->lastInsertId();
        } else {
            $res = 0;
        }
        return $res;
    }

    public function getID(string $sql, array $datos)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $stmt = $this->con->prepare("SELECT MAX(ID_PACIENTE) FROM registro");
            $stmt->execute();
            $res = $stmt->fetchColumn();
        } else {
            $res = NULL;
        }
        return $res;
    }

    public function getIDString(string $sql, array $datos, string $sql2)
    {
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $stmt = $this->con->prepare("$sql2");
            $stmt->execute();
            $res = $stmt->fetchColumn();
        } else {
            $res = NULL;
        }
        return $res;
    }

    public function downloadImage($sql, $filename, $img)
    {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetch(PDO::FETCH_ASSOC);

        // Obtener el contenido de la imagen y su tipo desde la consulta
        $imageContent = $data[$img];
        $imageType = $data['TIPO'];

        // Configurar las cabeceras para la descarga de la imagen
        header("Content-type: $imageType");
        header("Content-Disposition: inline; filename=$filename");
        header('Content-Length: ' . strlen($imageContent));
        echo $imageContent;
    }

    public function PDF(string $sql, string $filename)
    {
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetch(PDO::FETCH_ASSOC);

        // Obtener el contenido del PDF desde la consulta
        $pdfContent = $data['PDF'];

        // Mostrar el PDF en el navegador
        header('Content-type: application/pdf');
        header("Content-Disposition: inline; filename=$filename");
        header('Content-Length: ' . strlen($pdfContent));
        echo $pdfContent;
    }
}
