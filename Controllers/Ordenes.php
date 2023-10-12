<?php
class Ordenes extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }


    public function trabajo()
    {
        $data['title'] = 'Ordenes Internas - Orden de Trabajo | KYPBioingeniería';
        $data['activeTrabajo'] = 'active';
        $data['scripts'] = 'Ordenes/ordenTrabajo.js';
        $this->views->getView('Ordenes', 'trabajo', $data);
    }

}
