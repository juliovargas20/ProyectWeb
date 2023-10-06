<?php
class ProyectosModel extends Query{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUser()
    {
        $sql = "SELECT * FROM usuarios WHERE ESTADO = 1";
        return $this->selectAll($sql);
    }

}

?>