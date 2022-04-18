<?php

    class Manage extends Controller{

        function __construct()
        {
            parent::__construct();
            $this->view->employees = [];
            $this->view->roles = [];
            $this->view->areas = [];
            $this->view->employeeRoles = [];
            $this->errorMessage = [];
            $this->errorCounter = 0;
            $this->successMessage = "";
            
        }

        function render(){
            $this->view->employees = $this->model->get();
            $this->view->render('manage/index');
        }

        function edit($param = null){
           $employeeId = $param[0];
           $employee = $this->model->getById($employeeId);
          
           if($employee->id){
            $this->view->employee = $employee;
            $this->view->roles = $this->model->getRoles();
            $this->view->areas = $this->model->getAreas();
            $this->view->employeeRoles = $this->model->getRolbyId($employeeId);
            $this->view->render('manage/edit');
            
           }
           else{
            $this->view->errorMessage = "Empleado inexistente";
            $this->render();
           }

        }

        

        function update(){
            $validatedPost = $this->validatePost($_POST);
            $successMessage = "";
            $notice = 0;

            if($validatedPost){
                if(isset($_POST['notice']) && !empty(trim($_POST['notice']))){
                    
                    $notice = $_POST['notice'];
                }
               
                
                $data = [
                    'id' => $_POST['id'],
                    'fullname' => $_POST['fullname'],
                    'email' => $_POST['email'],
                    'sex' => $_POST['sex'],
                    'areaid' => $_POST['areaid'],
                    'description' => $_POST['description'],
                    'notice' => $notice,
                ];

                $roles = $_POST['roles'];

                $updateData = $this->model->update($data);

                $employeeId = $_POST['id'];

                $employeeData= [
                    'employeeid' => $employeeId
                ];

                $deleteRol = $this->model->deleteRol($employeeData);

                foreach ($roles as $key => $value) {
                    $rolData = [
                        'employeeid' => $employeeId,
                        'rolid' => $value
                    ];
                   
                    $insertRol = $this->model->insertRol($rolData);
                    
                    if($insertRol){
                        $successMessage = 'Empleado Actualizado';
                        
                    }
                    else{
                        $this->errorMessage[$this->errorCounter] = 'Error al actualizar el empleado';
                        $this->errorCounter++;
                        break;
                    }
                }
                
                if($updateData){
                    $successMessage = 'Empleado actualizado';
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
           
            $employee = new Employee();

            $employee->id = $_POST['id'];
            $employee->fullname = $_POST['fullname'];
            $employee->email = $_POST['email'];
            $employee->sex = $_POST['sex'];
            $employee->areaid = $_POST['areaid'];
            $employee->description = $_POST['description'];
            $employee->notice = $notice;
            
            $this->view->employee = $employee;
            $this->view->roles = $this->model->getRoles();
            $this->view->areas = $this->model->getAreas();
            $this->view->employeeRoles = $this->model->getRolbyId($_POST['id']);
            $this->view->render('manage/edit');

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

        function delete($parama = null){
            $employeeId = $parama[0];
            $deleteData = $this->model->delete($employeeId);
            $successMessage = "";
            $errorMessage = "";
            if($deleteData){
                $successMessage = 'Empleado eliminado';
            }
            else{
                $errorMessage = 'Error';
            }
            $this->view->successMessage = $successMessage;
            $this->view->errorMessage = $errorMessage;
            $this->render();
        }  

    }
?>