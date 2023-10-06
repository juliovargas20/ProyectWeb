<?php

class MyError extends Controller{

    public function index()
    {
        $this->views->getView('MyError', 'index');
    }

}

?>