<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear empleado</title>
</head>
<body>
<?php require('views/header.php')?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="center">Crear empleado</h2><br>
            <?php 
            if(isset($this->successMessage) && !empty($this->successMessage)){
            ?>
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <?php  echo $this->successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
            }
            ?> 
            <?php 
                if(!empty($this->errorMessage)){
                    foreach ($this->errorMessage as $error){
                        
            ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php  echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php 
                    }
                }
            ?> 
            <form id="form"  action="<?php echo constant('URL')?>create/insert" method="post">
                <div class="form-control">
                    <div class="form-group">
                        <label for="fullname">Nombre completo *</label>
                        <input  id="fullname" class="form-control"  type="text" name="fullname" placeholder="Ingrese el nombre completo" >
                        <small id="fullnameInfo" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electrónico *</label>
                        <input id="email" class="form-control" type="email" name="email" placeholder="Ingrese el correo electrónico">
                        <small id="emailInfo" class="form-text"></small>
                    </div>
                    <label for="sex">Sexo *</label>
                    <div class="form-check">
                        <input id="sex1" class="form-check-input" type="radio" name="sex" value="M">
                        <label class="form-check-label" >
                            Masculino
                        </label>
                        
                    </div>
                    <div class="form-check">
                        <input id="sex2" class="form-check-input" type="radio" name="sex" value="F">
                        <label class="form-check-label">
                            Femenino
                        </label><br>
                        
                    </div>
                    <div class="form-group">
                        <small id="sexInfo" class="form-text"></small>
                    </div>
                    <div  class="form-group">
                        <label for="area">Área *</label>
                        <select id="area" class="form-control" name="areaid" id="areaid">
                        <?php
                            include_once('models/areas.php');
                            foreach($this->areas as $row){
                                $area = new Area();
                                $area = $row;
                        ?>
                            <option value="<?php echo $area->id; ?>"><?php echo $area->name?></option>
                        <?php
                            }
                        ?>
                        </select>
                        <small id="areaInfo" class="form-text"></small>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción *</label>
                        <textarea id="description" class="form-control" name="description"  rows="3"></textarea>
                        <small id="descriptionInfo" class="form-text"></small>
                    </div>
                    <div class="form-check">
                        <input id="notice" class="form-check-input"  name="notice"  type="checkbox" value="1">
                        <label class="form-check-label" for="notice">
                            Deseo recibir boletín informativo
                        </label>
                        <small id="noticeInfo" class="form-text"></small>
                    </div>
                    <label for="roles">Roles *</label>
                    <?php
                        include_once('models/roles.php');
                        foreach($this->roles as $row){
                            $rol = new Rol();
                            $rol = $row;
                    ?>
                    <div class="form-check">
                        <input id="roles" class="form-check-input"  name="roles[]"  type="checkbox" value="<?php echo $rol->id?>">
                        <label class="form-check-label" for="notice">
                            <?php echo $rol->name; ?>
                        </label>
                    </div>
                    <?php     
                        }
                    ?>
                    <div class="form-group">
                        <small id="rolesInfo" class="form-text"></small><br>
                    </div>
                    <button id="submitBtn" type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?php echo constant('URL')?>public/js/validateForm.js"></script> 
</body>
</html>