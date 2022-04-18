<?php
    require_once('libs/controller.php');
    
    class errors extends Controller{
        function __construct(){
            parent::__construct();
            $this->view->mensaje = "Hubo un error en la solicitud o no existe la página";
            $this->view->render('errors/index');
            
        }
    }


?>