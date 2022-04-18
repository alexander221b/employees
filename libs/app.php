<?php

    require_once 'controllers/errors.php';

    class App{
        function __construct(){
            //Recibe todo el contenido de la url. Si existe contenido 
            //en la url $url es igual a la cadena ingresada si no es igual null
            $url = isset($_GET['url']) ? $_GET['url'] : null;
            //Retira el exceso de / al final de la url
            $url = rtrim($url,'/');
            //Separa el contenido de la url 
            $url = explode('/', $url);

            //Cuando se ingresa sin definir un controlador
            if(empty($url[0])){
                $archivoController = 'controllers/home.php';
                require_once $archivoController;
                //Instancia el controllador
                $controller = new Home();
                $controller->loadModel('home');
                $controller->render();
                return false;
            }

    
            //Crea la ubicación del controlador en el directorio
            $archivoController = 'controllers/' . $url[0] . '.php';

            //Verifica que el archivo exista en la carpeta controllers
            if(file_exists($archivoController)){
                require_once $archivoController;
                //Inicializa el controlador
                $controller = new $url[0];
                $controller->loadModel($url[0]);

                //Número de elementos de la url
                $nparam = sizeof($url);

                if($nparam > 1){
                    if($nparam > 2){
                        $param = [];
                        for($i=2; $i<$nparam; $i++){
                            array_push($param, $url[$i]);
                        }
                        
                        if(method_exists($controller, $url[1])){
                            //Se le pasan los parámetros al método
                            $controller->{$url[1]}($param);
                        }  
                        else{
                            $error = new Errors(); 
                        }  
                    } //Si no hay parámetros, sólo se llama al método
                    else{
                        
                        if(method_exists($controller, $url[1])){
                            $controller->{$url[1]}();
                        }
                        else{
                            $error = new Errors(); 
                        }
                    }
                }else{
                    $controller->render();
                }  
            }
            else{
                $error = new Errors();
            }

        }
    }

?>
