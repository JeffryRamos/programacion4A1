<?php
//incluir LA BASE DE DATOS 
/*
 AYUDAAAAAA..... NO ENTIENDO COMO INCLUIR LA BASE DE DATOS


include('../../Config/Config.php');
$registro_usuarios = new registro($conexion);
*/


//definir variables
$username = $NombreUser = $ApellidoUser = $password = $email = "";
$username_error = $NombreUser_error = $ApellidoUser_error = $password_error = $email_error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    //validando campo de nombre de usuario
    if(empty(trim($_POST["NombreUser"]))){
        $NombreUser_error ="por favor, ingrese su nombre";
    } else{
        //prepara una declaracion de seleccion
        $conexion = "SELECT id FROM usuarios WHERE nombre_user = ?";

        if($stmt = mysqli_prepare($link,$conexion)){
            mysqli_stmt_bind_param($stmt,"s",$param_NombreUser);

            $param_NombreUser = trim($_POST["NombreUser"]);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt)== 1){
                    $NombreUser_error = "este nombre ya existe";
                } 

            }else{
                echo "Ups! algo salio mal, intentar mas tarde";
            }
        }
    }
}






?>