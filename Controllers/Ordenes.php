<?php
class Ordenes extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    /***** ORDEN DE COMPRA *****/
    public function compra()
    {
        $data['title'] = 'Ordenes Internas - Orden de Compra | KYPBioingeniería';
        $data['activeOrdenCompra'] = 'active';
        $data['scripts'] = 'Ordenes/ordenCompra.js';
        $this->views->getView('Ordenes', 'compra', $data);
    }
}
