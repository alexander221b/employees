<?php

require_once('models/employee.php');
require_once('models/areas.php');
require_once('models/roles.php');
require_once('models/employeeRol.php');

class ManageModel extends Model{
    public function __construct(){
        parent::__construct();
    }

    public function get(){
       $employees = [];
       try{
          $query = $this->db->connect()->query("SELECT * FROM empleado");
          while($row = $query->fetch()){
            $employee = new Employee();
            $employee->id = $row['id'];
            $employee->fullname = $row['nombre'];
            $sexo = "";
            if($row['sexo'] == "M"){
              $sexo = "Masculino";
            }
            if($row['sexo'] == "F"){
                $sexo = "Femenino";
            }
            $employee->email = $row['email'];
            $employee->sex =  $sexo;
            $area = $this->getAreabyId($row['area_id']);
            $employee->areaid =  $area->name;
            if($row['boletin'] == 1){
                $notice = "Si";
            }
            if($row['boletin'] == 0){
                $notice = "No";
            }
            $employee->notice = $notice;
            $employee->description = $row['descripcion'];
            array_push($employees, $employee);
          }
          return $employees;
       }catch (PDOException $e){
           return [];
       }
       
    }

    function getAreabyId($areaId){
       $area = new Area();
       $query = $this->db->connect()->prepare("SELECT * FROM areas WHERE id = :id");
       try {
           $query->execute(['id' => $areaId]);
           while($row = $query->fetch()){
              $area->name = $row['nombre'];
           }
           return  $area;
       }catch(PDOException $e){
            return null;
       }
    }

    public function getById($employeeId){
       $employee = new Employee();
       $query = $this->db->connect()->prepare("SELECT * FROM empleado WHERE id = :id");
       try {
           $query->execute(['id' => $employeeId]);
           while($row = $query->fetch()){
              $employee->id = $row['id'];
              $employee->fullname = $row['nombre'];
              $employee->email = $row['email'];
              $employee->sex = $row['sexo'];
              $employee->areaid = $row['area_id'];
              $employee->notice = $row['boletin'];
              $employee->description = $row['descripcion'];
           }
           return  $employee;
       }catch(PDOException $e){
            return null;
       }
    }

    public function update($data){
        try{
            $query = $this->db->connect()->prepare('UPDATE empleado SET NOMBRE = :fullname, EMAIL = :email, SEXO = :sex, AREA_ID = :areaid, BOLETIN  = :notice, DESCRIPCION  = :description WHERE id = :id');
            $query->execute(
                            [   
                                'id' => $data['id'],
                                'fullname' => $data['fullname'],
                                'email' => $data['email'],
                                'sex' => $data['sex'],
                                'areaid' => $data['areaid'],
                                'notice' => $data['notice'],
                                'description' => $data['description']
                            ]);
            return true;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public function deleteRol($data){
        try{
            $query = $this->db->connect()->prepare('DELETE FROM empleado_rol WHERE empleado_id = :employeeid');
            $query->execute(
                [   
                    'employeeid' => $data['employeeid'] 
                ]);
                return true;
            }catch(PDOException $e){
                echo $e->getMessage();
                return false;
            }
    }
     

    public function delete($id){
        try{
            $query = $this->db->connect()->prepare('DELETE FROM empleado WHERE id = :id');
            $query->execute(
                [   
                    'id' => $id
                ]);
                return true;
            }catch(PDOException $e){
                //echo $e->getMessage();
                return false;
            }
    }

    public function getRoles(){
        $roles = [];
        try{
           $query = $this->db->connect()->query("SELECT * FROM roles");
           while($row = $query->fetch()){
             $rol = new Rol();
             $rol->id = $row['id'];
             $rol->name = $row['nombre'];
             array_push($roles, $rol);
           }
           return $roles;
        }catch (PDOException $e){
            return [];
        }
        
     }

     function getRolbyId($rolId){
        $employeeRoles = [];
        $query = $this->db->connect()->prepare("SELECT * FROM empleado_rol WHERE empleado_id = :id");
        try {
            $query->execute(['id' => $rolId]);
            while($row = $query->fetch()){
                $employeeRol = new EmployeeRol();
                $employeeRol->employeeId = $row['empleado_id'];
                $employeeRol->rolId = $row['rol_id'];
                array_push($employeeRoles, $employeeRol);
            }
            return  $employeeRoles;
        }catch(PDOException $e){
             return null;
        }
     }

     public function getAreas(){
        $areas = [];
        try{
           $query = $this->db->connect()->query("SELECT * FROM areas");
           while($row = $query->fetch()){
             $area = new Area();
             $area->id = $row['id'];
             $area->name = $row['nombre'];
             array_push($areas, $area);
           }
           return $areas;
        }catch (PDOException $e){
            return [];
        }
        
     }

     public function insertRol($data){
        try{
            $query = $this->db->connect()->prepare('INSERT INTO EMPLEADO_ROL (EMPLEADO_ID, ROL_ID) VALUES (:employeeid, :rolid)');
            $query->execute(
                            [
                                'employeeid' => $data['employeeid'],
                                'rolid' => $data['rolid']
                            ]);
            return true;
        }catch(PDOException $e){
            //echo $e->getMessage();
            return false;
        }
       
    }


   


    
}

?>