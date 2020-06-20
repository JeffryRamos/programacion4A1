<?php session_start();


    
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        
        $password = hash('sha512', $password);
        $password2 = hash('sha512', $password2);
        
        $error = '';
        
        if (empty($nombre) or empty($email) or empty($usuario) or empty($password) or empty($password2)){
            
            $error .= '<i>Favor de rellenar todos los campos</i>';
        }else{
            try{
                $conexion = new PDO('mysql:host=localhost;dbname=db_app_biblioteca', 'root', '');
            }catch(PDOException $prueba_error){
                echo "Error: " . $prueba_error->getMessage();
            }
            
            $statement = $conexion->prepare('SELECT * FROM registros WHERE usuario = :usuario LIMIT 1');
            $statement->execute(array(':usuario' => $usuario));
            $resultado = $statement->fetch();
            
                        
            if ($resultado != false){
                $error .= '<i>Este usuario ya existe</i>';
            }
            
            if ($password != $password2){
                $error .= '<i> Las contraseñas no coinciden</i>';
            }
            
            
        }
        
        if ($error == ''){
            $statement = $conexion->prepare('INSERT INTO registros (idRegistro, nombre, email, usuario, password) VALUES (null, :nombre, :email, :usuario, :password)');
            $statement->execute(array(
                
                ':nombre' => $nombre,
                ':email' => $email,
                ':usuario' => $usuario,
                ':password' => $password
                
            ));
            
            $error .= '<i style="color: green;">Usuario registrado exitosamente</i>';
        }
    }


    require 'login/registro-vista.php';

?>