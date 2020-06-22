<?php session_start();
/*en esta seccion es donde el usuario podra cerrar secion en el momento que el desee 
volviendolo a la pagina de inicio  */

    session_destroy();
    $_SESSION = array();
    
    header('location: index.php');

?>