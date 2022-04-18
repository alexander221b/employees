<?php

require_once('models/roles.php');
require_once('models/areas.php');

class CreateModel extends Model{
    public function __construct(){
        parent::__construct();
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

    public function insert($data){
        try{
            
            $query = $this->db->connect()->prepare('INSERT INTO EMPLEADO (NOMBRE, EMAIL, SEXO, AREA_ID, BOLETIN, DESCRIPCION) VALUES (:fullname, :email, :sex, :areaid, :notice, :description)');
            $query->execute(
                            [
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

    public function getLastId(){
        try{
           $query = $this->db->connect()->prepare("SELECT MAX( id ) as max_id FROM EMPLEADO");
           $query->execute();
           $lastId = $query -> fetch(PDO::FETCH_ASSOC);
           return $lastId['max_id'];
            
        }catch (PDOException $e){
            //echo $e->getMessage();
           return NULL;
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