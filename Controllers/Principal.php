<?php
class Principal extends Controller
{
    public function __construct() {
        
        session_start();
        if (!empty($_SESSION['activo'])) {
            header("location: ". BASE_URL. "Usuarios");
        }
        parent::__construct();
    }

    public function index()
    {
        $this->views->getView('principal', 'index');
    }

    
}
