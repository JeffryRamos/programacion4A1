<?php
    /*Se realiza la conecxion con la base de datos para almacenar y extraer datos */
    try{
         $conexion = new PDO('mysql:host=localhost;dbname=db_app_biblioteca', 'root', '');
    }catch(PDOException $prueba_error){
        echo "Error: " . $prueba_error->getMessage();
    }


?>