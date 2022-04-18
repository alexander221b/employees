<?php
    //Controlador base para todos los controladores
    class Controller{
        function __construct()
        {
            //echo '<p>Controlador base</p>';
            $this->view = new View();
        }

        //No se crea en el construct el modelo ya que hay páginas q no necesitan conexión a db 
        //y son sólo texto. Por esto es mejor crear la conexión con el modelo en una función
        function loadModel($model){
            $url = 'models/'.$model.'model.php';
            if(file_exists($url)){
                require $url;
                $modelName = $model.'Model';
                $this->model = new $modelName();
            }
        }
    }



?>