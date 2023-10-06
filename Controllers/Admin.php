<?php
class Admin extends Controller
{
    public function __construct() {
        
        session_start();
        parent::__construct();
    }

    public function index()
    {

        if (empty($_SESSION['activo'])) {
            header("Location: " . BASE_URL);
        }

        $data['title'] = 'Panel Principal | KYPBioingenieria'; 
        $this->views->getView('admin', 'home', $data);
    }

    
}
