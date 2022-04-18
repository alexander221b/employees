<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar empleados</title>
     <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <?php require('views/header.php')?>

        <div class="container">
            <div class="row justify-content-center" >
                <div class="col-md-12">
                    <h2 class="center">Administrar empleados</h2><br>
                   
                  
                    <?php 
                    if(isset($this->successMessage) && !empty($this->successMessage)){
                    ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <?php  echo $this->successMessage; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php 
                       $this->successMessage="";
                    }
                    ?> 
                    <?php 
                    if(isset($this->errorMessage) && !empty($this->errorMessage)){
                    ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php  echo $this->errorMessage; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php 
                    }
                    ?> 
                    <table id="employees" class="table">
                        <thead><tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Sexo</th>
                            <th>Area</th>
                            <th>Boletín</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                include_once('models/employee.php');
                                foreach($this->employees as $row){
                                    $employee = new Employee();
                                    $employee = $row;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $employee->id; ?>
                                </td>
                                <td>
                                    <?php echo $employee->fullname; ?>
                                </td>
                                <td>
                                    <?php echo $employee->email; ?>
                                </td>
                                <td>
                                    <?php echo $employee->sex; ?>
                                </td>
                                <td>
                                    <?php echo $employee->areaid; ?>
                                </td>
                                <td>
                                    <?php echo $employee->notice; ?>
                                </td>
                                <td>
                                    <a href="<?php echo constant('URL').'manage/edit/'.$employee->id;?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                </td>
                                <td>
                                    <a href="<?php echo constant('URL').'manage/delete/'.$employee->id;?>" onclick="return confirm('¿Está seguro que desea eliminar el registro?')"><i class="fa-solid fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#employees').DataTable({
                "order": [[ 0, "desc" ]],
                "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }
                
                ]
               });
        } );
    </script>
</body>


</html>