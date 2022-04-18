<?php

    class Create extends Controller{
        function __construct()
        {
            parent::__construct();
            $this->successMessage = "";
            $this->errorMessage = [];
            $this->view->roles = [];
            $this->view->areas = [];
            $this->errorCounter = 0;
        }

        function render(){
            $this->view->roles = $this->model->getRoles();
            $this->view->areas = $this->model->getAreas();
            $this->view->render('create/index');
        }

        function insert(){
            $validatedPost = $this->validatePost($_POST);
            $successMessage = "";
            if($validatedPost){
                $data = [
                    'fullname' => $_POST['fullname'],
                    'email' => $_POST['email'],
                    'sex' => $_POST['sex'],
                    'areaid' => $_POST['areaid'],
                    'description' => $_POST['description'],
                    'notice' => $_POST['notice'],
                ];
                $roles = $_POST['roles'];
                $insertData = $this->model->insert($data);
                $lastId = $this->model->getLastId();
                foreach ($roles as $key => $value) {
                    $rolData = [
                        'employeeid' => $lastId,
                        'rolid' => $value
                    ];
                    $insertRol = $this->model->insertRol($rolData);
                    if($insertRol){
                        $successMessage = 'Empleado ingresado';
                    }
                    else{
                        $this->errorMessage[$this->errorCounter] = 'Error al ingresar el empleado';
                        $this->errorCounter++;
                        break;
                    }
                }
                if($insertData){
                  $successMessage = 'Empleado ingresado';
                }
                else{
                    $this->errorMessage[$this->errorCounter] = 'Error al ingresar el empleado';
                    $this->errorCounter++;
                }
                $this->view->successMessage = $successMessage;
            }
            else{
                $this->view->errorMessage = $this->errorMessage;
            }
            $this->render();
        }

        function validatePost($post){
            $validatedPost = true;
            if(!isset($post['fullname']) || empty(trim($post['fullname']))){
                $this->errorMessage[$this->errorCounter] = "El nombre no puede ser vacío.";
                $this->errorCounter++;
                $validatedPost = false;
            }else{
                if (!preg_match("/^([a-zA-Z\sÁÉÍÓÚáéíóúÑñ]+)$/", $post['fullname'])) {
                    $this->errorMessage[$this->errorCounter] = "El nombre sólo puede contener letras.";
                    $this->errorCounter++;
                    $validatedPost = false;
                }
            }
            if(!isset($post['email']) ||  empty(trim($post['email']))){
                $this->errorMessage[$this->errorCounter] = "El correo no puede ser vacío.";
                $this->errorCounter++;
                $validatedPost = false;
            }else{
                if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    $this->errorMessage[$this->errorCounter] = "El formato del correo es incorrecto.";
                    $this->errorCounter++;
                    $validatedPost = false;
                }
            }
            if(!isset($post['sex']) || empty(trim($post['sex']))){
                $this->errorMessage[$this->errorCounter] = "El sexo no puede ser vacío.";
                $this->errorCounter++;
                $validatedPost = false;
            }
            if(!isset($post['areaid']) || empty(trim($post['areaid']))){
                $this->errorMessage[$this->errorCounter] = "El area no puede ser vacía.";
                $this->errorCounter++;
                $validatedPost = false;
            }
            if(!isset($post['description']) ||  empty(trim($post['description']))){
                $this->errorMessage[$this->errorCounter] = "La descripción no puede ser vacía.";
                $this->errorCounter++;
                $validatedPost = false;
            }
            if(!isset($post['roles']) || empty($post['roles'])){
                $this->errorMessage[$this->errorCounter] = "El rol no puede ser vacío.";
                $this->errorCounter++;
                $validatedPost = false;
            }
            return $validatedPost;
        }
    }
?>