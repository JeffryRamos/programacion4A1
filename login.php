<?php session_start();

/* Es la pantalla de inicio de secion donde el usuario o el administrador
donde solo le pide nombre de usuario y contraseña */
    $error = '';
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $password = hash('sha512', $password);
        
        /*es donde se hace la respectiva coneccion con la base de datos, y hace el llamado de los datos requeridos */
        try{
            $conexion = new PDO('mysql:host=localhost;dbname=db_app_biblioteca', 'root', '');
            }catch(PDOException $prueba_error){
                echo "Error: " . $prueba_error->getMessage();
            }
        
        $statement = $conexion->prepare('
        SELECT * FROM registros WHERE usuario = :usuario AND password = :password'
        );

        /* donde el usuario debe ingresar los datos requeridos para inicar cession */
        $statement->execute(array(
            ':usuario' => $usuario,
            ':password' => $password
        ));
            
        $resultado = $statement->fetch();
        
        /*Evalua los datos ingresados y si no se encuntra una concordancia emite un mensaje de error  */
        if ($resultado !== false){
            $_SESSION['usuario'] = $usuario;
            header('location: principal.html');
        }

        else {
            $error .= '<i>Este usuario no existe</i>';
        }
    }
    
require 'login/login-vista.php';


?>