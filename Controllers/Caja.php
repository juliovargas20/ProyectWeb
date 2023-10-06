<?php
class Caja extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function index()
    {
        $data['title'] = 'Caja Empresarial - Caja | KYPBioingeniería';
        $data['activeCaja'] = 'active';
        $data['scripts'] = 'Caja/caja.js';
        $this->views->getView('Caja', 'CajaChica', $data);
    }


}
