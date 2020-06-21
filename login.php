<?php session_start();

    $error = '';
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $password = hash('sha512', $password);
        
        try{
            $conexion = new PDO('mysql:host=localhost;dbname=db_app_biblioteca', 'root', '');
            }catch(PDOException $prueba_error){
                echo "Error: " . $prueba_error->getMessage();
            }
        
        $statement = $conexion->prepare('
        SELECT * FROM registros WHERE usuario = :usuario AND password = :password'
        );
        
        $statement->execute(array(
            ':usuario' => $usuario,
            ':password' => $password
        ));
            
        $resultado = $statement->fetch();
        
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