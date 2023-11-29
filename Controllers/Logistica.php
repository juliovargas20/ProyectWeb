<?php
class Logistica extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    /************** <LISTADO DE PACIENTES> **************/

    public function importaciones()
    {
        $data['title'] = 'Logística - Orden de Importaciones | KYPBioingeniería';
        $data['activeImport'] = 'active';
        $data['scripts'] = 'Logistica/importaciones.js';
        $this->views->getView('Logistica', 'importacion', $data);
    }
}
