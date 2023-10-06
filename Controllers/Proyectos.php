<?php
class Proyectos extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function Enumeracion()
    {
        $data['title'] = 'Proyectos de Innovación - Enumeración | KYPBioingeniería';
        $data['activeProyecto'] = 'active';
        $data['scripts'] = 'Proyectos/enumeracion.js';
        $data['user'] = $this->model->getUser();
        $this->views->getView('Proyectos', 'enumeracion', $data);
    }


}
